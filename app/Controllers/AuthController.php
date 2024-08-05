<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    // Reglas de validación del formulario de inicio de sesión.
    private function getValidationRules()
    {
        return [
            'correo'     => 'required|max_length[50]|valid_email|is_not_unique[usuarios.correo,estatus,1]',
            'contrasena' => 'required|max_length[25]|alpha_dash',
        ];
    }

    // Renderiza la página del formulario de inicio de sesión.
    public function loginView()
    {
        helper('form');

        return view('auth/login');
    }

    // Inicia la sesión de un usuario.
    public function loginAction()
    {
        $rules = $this->getValidationRules();

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost(array_keys($rules));

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('auth.loginView')->withInput();
        }

        $userModel = model(UserModel::class);

        // Consulta la información del usuario.
        $user = $userModel->select('idUsuario, contrasena')
            ->where('correo', trim($data['correo']))
            ->first();

        // Valida la contraseña del usuario.
        if ($user['contrasena'] !== $data['contrasena']) {
            return redirect()->route('auth.loginView')
                ->withInput()
                ->with('error', 'Acceso no permitido');
        }

        // Genera la cookie de autenticación (24 horas).
        $this->response->setCookie('userAuth', $user['idUsuario'], 60 * 60 * 24);

        return redirect()->route('products.index')->withCookies();
    }

    // Cierra la sesión de un usuario.
    public function logoutAction()
    {
        $this->response->deleteCookie('userAuth');

        session()->remove('userAuth');

        return redirect()->route('auth.loginView')->withCookies();
    }
}
