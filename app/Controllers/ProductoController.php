<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class ProductoController extends BaseController
{
    // Renderiza la página del formulario de registro de productos.
    public function new()
    {
        helper('form');

        return view('productos/new');
    }

    // Registra un nuevo producto.
    public function create()
    {
        $data = $this->request->getPost(['nombre', 'precio']);

        $productoModel = model(ProductoModel::class);

        $rules = [
            'nombre' => "required|max_length[40]|is_unique[{$productoModel->table}.nombre]",
            'precio' => 'required|numeric|greater_than[0]|regex_match[/^\d{1,14}(\.\d{1,2})?$/]',
        ];

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

        return view('productos/index', $data);
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

        return view('productos/edit', $data);
    }
}
