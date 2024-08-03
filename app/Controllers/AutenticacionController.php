<?php

namespace App\Controllers;

class AutenticacionController extends BaseController
{
    public function loginView()
    {
        return view('autenticacion/login');
    }

    public function loginAction()
    {
    }
}
