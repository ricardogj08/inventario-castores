<?php

namespace App\Controllers;

use App\Models\MovimientoModel;
use App\Models\ProductoModel;
use App\Models\TipoMovimientoModel;

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
        $fields = ['nombre', 'precio'];

        $rules = [];

        foreach ($fields as $field) {
            $rules[$field] = $this->getValidationsRules()[$field];
        }

        $productoModel = model(ProductoModel::class);

        // Valida que el nombre sea único.
        $rules['nombre'] .= "|is_unique[{$productoModel->table}.nombre]";

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost($fields);

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('productos.new')->withInput();
        }

        helper('text');

        // Elimina espacios sobrantes.
        $data['nombre'] = reduce_multiples($data['nombre'], ' ', true);

        // Registra el nuevo producto.
        $productoModel->insert($data);

        return redirect()->route('productos.index')
            ->with('success', 'El producto se ha registrado correctamente');
    }

    // Renderiza la página de todos los productos.
    public function index()
    {
        $productoModel = model(ProductoModel::class);

        $query = $productoModel->select("{$productoModel->primaryKey} AS id, nombre, precio, cantidad, estatus, fecha_registro");

        $userAuthRol = session('userAuth.rol');

        // Filtra los productos dependiendo del rol del usuario.
        if ($userAuthRol === 'Almacenista') {
            $query->where('estatus', 1);
        }

        // Consulta todos los productos registrados.
        $products = $query->orderBy('fecha_registro', 'DESC')->findAll();

        $data = compact('products');

        return view('products/index', $data);
    }

    // Renderiza la página del formulario de edición de productos.
    public function edit(int $id)
    {
        $productoModel = model(ProductoModel::class);

        $query = $productoModel->select("{$productoModel->primaryKey} AS id, nombre, precio, cantidad, estatus, fecha_registro");

        $userAuthRol = session('userAuth.rol');

        // Filtra la búsqueda del producto dependiendo del rol del usuario.
        if ($userAuthRol === 'Almacenista') {
            $query->where('estatus', 1);
        }

        // Consulta la información del producto.
        $product = $query->find($id);

        // Valida si existe el producto.
        if (empty($product)) {
            return redirect()->route('productos.index')
                ->with('error', 'No puedes editar este producto');
        }

        helper('form');

        $data = compact('userAuthRol', 'product');

        return view('products/edit', $data);
    }

    // Modifica la información de un producto como administrador.
    private function updateFromAdmin(array $product)
    {
        $rules = $this->getValidationsRules();

        $productoModel = model(ProductoModel::class);

        // Valida que el nombre sea único a excepción de el mismo.
        $rules['nombre'] .= "|is_unique[{$productoModel->table}.nombre,{$productoModel->primaryKey},{$product['id']}]";

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost(array_keys($rules));

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('productos.edit', [$product['id']])->withInput();
        }

        helper('text');

        // Elimina espacios sobrantes.
        $data['nombre'] = reduce_multiples($data['nombre'], ' ', true);

        if (empty($data['estatus'])) {
            $data['estatus'] = 0;
        }

        $amount = $data['cantidad'];

        // Suma la cantidad de productos.
        $data['cantidad'] += $product['cantidad'];

        // Modifica la información del producto.
        $productoModel->update($product['id'], $data);

        if (! empty($amount)) {
            $tipoMovimientoModel = model(TipoMovimientoModel::class);

            // Consulta la información del tipo de movimiento.
            $type = $tipoMovimientoModel->select("{$tipoMovimientoModel->primaryKey} AS id")
                ->where('nombre', 'Entrada')
                ->first();

            $movimientoModel = model(MovimientoModel::class);

            // Registra el movimiento del producto.
            $movimientoModel->insert([
                'idProducto'       => $product['id'],
                'idTipoMovimiento' => $type['id'],
                'idUsuario'        => session('userAuth.id'),
                'cantidad'         => $amount,
            ]);
        }

        return redirect()->route('productos.index')
            ->with('success', 'El producto se ha modificado correctamente');
    }

    // Modifica la información de un producto como Almacenista.
    private function updateFromStorer(array $product)
    {
        $fields = ['cantidad'];

        $rules = [];

        foreach ($fields as $field) {
            $rules[$field] = $this->getValidationsRules()[$field];
        }

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost($fields);

        // La cantidad de inventario a restar debe ser menor o igual a la cantidad disponible.
        $rules['cantidad'] .= "|less_than_equal_to[{$product['cantidad']}]";

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('productos.edit', [$product['id']])->withInput();
        }

        $amount = $data['cantidad'];

        // Resta la cantidad de productos.
        $data['cantidad'] = $product['cantidad'] - $amount;

        $productoModel = model(ProductoModel::class);

        // Modifica la información del producto.
        $productoModel->update($product['id'], $data);

        if (! empty($amount)) {
            $tipoMovimientoModel = model(TipoMovimientoModel::class);

            // Consulta la información del tipo de movimiento.
            $type = $tipoMovimientoModel->select("{$tipoMovimientoModel->primaryKey} AS id")
                ->where('nombre', 'Salida')
                ->first();

            $movimientoModel = model(MovimientoModel::class);

            // Registra el movimiento del producto.
            $movimientoModel->insert([
                'idProducto'       => $product['id'],
                'idTipoMovimiento' => $type['id'],
                'idUsuario'        => session('userAuth.id'),
                'cantidad'         => $amount,
            ]);
        }

        return redirect()->route('productos.index')
            ->with('success', 'El producto se ha modificado correctamente');
    }

    // Modifica la información de un producto.
    public function update(int $id)
    {
        $productoModel = model(ProductoModel::class);

        $query = $productoModel->select("{$productoModel->primaryKey} AS id, cantidad");

        $userAuthRol = session('userAuth.rol');

        // Filtra la búsqueda del producto dependiendo del rol del usuario.
        if ($userAuthRol === 'Almacenista') {
            $query->where('estatus', 1);
        }

        // Consulta la información del producto.
        $product = $query->find($id);

        // Valida si existe el producto.
        if (empty($product)) {
            return redirect()->route('productos.index')
                ->with('error', 'No puedes actualizar este producto');
        }

        // Modifica la información del producto dependiendo del rol del usuario.
        if ($userAuthRol === 'Administrador') {
            return $this->updateFromAdmin($product);
        }

        return $this->updateFromStorer($product);
    }
}
