<?php

namespace App\Controllers;

class ProductoController extends BaseController
{
    // Renderiza el formulario de registro de productos.
    public function new()
    {
        helper('form');

        return view('productos/new');
    }

    public function create()
    {
    }
}
