<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionTypeModel;

class ProductController extends BaseController
{
    // Reglas de validación.
    private function getValidationsRules()
    {
        return [
            'nombre'   => 'required|max_length[40]',
            'precio'   => 'required|numeric|greater_than[0]|regex_match[/^\d{1,14}(\.\d{1,2})?$/]',
            'estatus'  => 'permit_empty|in_list[1]',
            'cantidad' => 'required|is_natural|regex_match[/^\d{1,4}$/]',
        ];
    }

    // Renderiza la página del formulario de registro de productos.
    public function new()
    {
        helper('form');

        return view('products/new');
    }

    // Registra un nuevo producto.
    public function create()
    {
        $rules = [];

        $fields = ['nombre', 'precio'];

        foreach ($fields as $field) {
            $rules[$field] = $this->getValidationsRules()[$field];
        }

        // Valida que el nombre sea único.
        $rules['nombre'] .= '|is_unique[productos.nombre]';

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost($fields);

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('products.new')->withInput();
        }

        helper('text');

        // Elimina espacios sobrantes.
        $data['nombre'] = reduce_multiples($data['nombre'], ' ', true);

        $productModel = model(ProductModel::class);

        // Registra el nuevo producto.
        $productModel->insert($data);

        return redirect()->route('products.index')
            ->with('success', 'El producto se ha registrado correctamente');
    }

    // Renderiza la página de todos los productos.
    public function index()
    {
        $productModel = model(ProductModel::class);

        $query = $productModel->select('idProducto, nombre, precio, cantidad, estatus, fecha_registro, fecha_modificacion');

        $userAuthRole = session('userAuth.rol');

        // Filtra los productos dependiendo del rol del usuario.
        if ($userAuthRole === 'Almacenista') {
            $query->where('estatus', 1);
        }

        // Consulta todos los productos registrados.
        $products = $query->orderBy('fecha_registro', 'DESC')->findAll();

        $data = compact('products', 'userAuthRole');

        return view('products/index', $data);
    }

    // Renderiza la página del formulario de edición de productos.
    public function edit(int $id)
    {
        $productModel = model(ProductModel::class);

        $query = $productModel->select('idProducto, nombre, precio, cantidad, estatus, fecha_registro');

        $userAuthRole = session('userAuth.rol');

        // Filtra la búsqueda del producto dependiendo del rol del usuario.
        if ($userAuthRole === 'Almacenista') {
            $query->where('estatus', 1);
        }

        // Consulta la información del producto.
        $product = $query->find($id);

        // Valida si existe el producto.
        if (empty($product)) {
            return redirect()->route('products.index')
                ->with('error', 'No puedes editar este producto');
        }

        helper('form');

        $data = compact('userAuthRole', 'product');

        return view('products/edit', $data);
    }

    // Modifica la información de un producto como administrador.
    private function updateFromAdmin(array $product)
    {
        $rules = $this->getValidationsRules();

        // Valida que el nombre sea único a excepción de el mismo.
        $rules['nombre'] .= "|is_unique[productos.nombre,idProducto,{$product['idProducto']}]";

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost(array_keys($rules));

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('products.edit', [$product['idProducto']])->withInput();
        }

        helper('text');

        // Elimina espacios sobrantes.
        $data['nombre'] = reduce_multiples($data['nombre'], ' ', true);

        if (empty($data['estatus'])) {
            $data['estatus'] = 0;
        }

        // Cantidad de productos agregados.
        $amount = $data['cantidad'];

        // Suma la cantidad de productos.
        $data['cantidad'] += $product['cantidad'];

        $productModel = model(ProductModel::class);

        // Modifica la información del producto.
        $productModel->update($product['idProducto'], $data);

        if (! empty($amount)) {
            $transactionTypeModel = model(TransactionTypeModel::class);

            // Consulta la información del tipo de movimiento.
            $transactionType = $transactionTypeModel->select('idTipoMovimiento')
                ->where('nombre', 'Entrada')
                ->first();

            $transactionModel = model(TransactionModel::class);

            // Registra el movimiento del producto.
            $transactionModel->insert([
                'idProducto'       => $product['idProducto'],
                'idTipoMovimiento' => $transactionType['idTipoMovimiento'],
                'idUsuario'        => session('userAuth.idUsuario'),
                'cantidad'         => $amount,
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'El producto se ha modificado correctamente');
    }

    // Modifica la información de un producto como Almacenista.
    private function updateFromStorer(array $product)
    {
        $rules = [];

        $fields = ['cantidad'];

        foreach ($fields as $field) {
            $rules[$field] = $this->getValidationsRules()[$field];
        }

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost($fields);

        // La cantidad de inventario a restar debe ser menor o igual a la cantidad disponible.
        $rules['cantidad'] .= "|less_than_equal_to[{$product['cantidad']}]";

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('products.edit', [$product['idProducto']])->withInput();
        }

        // Cantidad de productos a restar.
        $amount = $data['cantidad'];

        // Resta la cantidad de productos.
        $data['cantidad'] = $product['cantidad'] - $amount;

        $productModel = model(ProductModel::class);

        // Modifica la información del producto.
        $productModel->update($product['idProducto'], $data);

        if (! empty($amount)) {
            $transactionTypeModel = model(TransactionTypeModel::class);

            // Consulta la información del tipo de movimiento.
            $transactionType = $transactionTypeModel->select('idTipoMovimiento')
                ->where('nombre', 'Salida')
                ->first();

            $movimientoModel = model(TransactionModel::class);

            // Registra el movimiento del producto.
            $movimientoModel->insert([
                'idProducto'       => $product['idProducto'],
                'idTipoMovimiento' => $transactionType['idTipoMovimiento'],
                'idUsuario'        => session('userAuth.idUsuario'),
                'cantidad'         => $amount,
            ]);
        }

        return redirect()->route('products.index')
            ->with('success', 'El producto se ha modificado correctamente');
    }

    // Modifica la información de un producto.
    public function update(int $id)
    {
        $productModel = model(ProductModel::class);

        $query = $productModel->select('idProducto, cantidad');

        $userAuthRole = session('userAuth.rol');

        // Filtra la búsqueda del producto dependiendo del rol del usuario.
        if ($userAuthRole === 'Almacenista') {
            $query->where('estatus', 1);
        }

        // Consulta la información del producto.
        $product = $query->find($id);

        // Valida si existe el producto.
        if (empty($product)) {
            return redirect()->route('products.index')
                ->with('error', 'No puedes actualizar este producto');
        }

        // Modifica la información del producto dependiendo del rol del usuario.
        if ($userAuthRole === 'Administrador') {
            return $this->updateFromAdmin($product);
        }

        return $this->updateFromStorer($product);
    }
}
