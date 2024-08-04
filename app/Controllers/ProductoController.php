<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class ProductoController extends BaseController
{
    // Renderiza el formulario de registro de productos.
    public function new()
    {
        helper('form');

        return view('productos/new');
    }

    // Registra un nuevo producto.
    public function create()
    {
        $data = $this->request->getPost(['nombre', 'precio']);

        $rules = [
            'nombre' => 'required|max_length[40]|is_unique[productos.nombre]',
            'precio' => 'required|numeric|greater_than[0]|regex_match[/^\d{1,14}(\.\d{1,2})?$/]',
        ];

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('productos.new')->withInput();
        }

        $productoModel = model(ProductoModel::class);

        helper('text');

        // Elimina espacios sobrantes.
        $data['nombre'] = reduce_multiples($data['nombre'], ' ', true);

        // Registra el nuevo producto.
        $productoModel->insert($data);

        return redirect()->route('productos.index')
            ->with('success', 'El producto se ha registrado correctamente');
    }

    public function index()
    {
    }
}
