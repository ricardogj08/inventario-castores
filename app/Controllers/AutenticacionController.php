<?php

namespace App\Controllers;

class AutenticacionController extends BaseController
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

        return view('autenticacion/login');
    }

    // Inicia la sesión de un usuario.
    public function loginAction()
    {
        $rules = $this->getValidationRules();

        // Obtiene solo los campos permitidos.
        $data = $this->request->getPost(array_keys($rules));

        // Valida los campos del formulario.
        if (! $this->validateData($data, $rules)) {
            return redirect()->route('autenticacion.loginView')->withInput();
        }

        $usuarioModel = model('App\Models\UsuarioModel');

        $primaryKeyFieldName = $usuarioModel->primaryKey;

        // Consulta la información del usuario.
        $user = $usuarioModel->select([$primaryKeyFieldName, 'contrasena'])
            ->where('correo', trim($data['correo']))
            ->first();

        // Valida la contraseña del usuario.
        if ($user['contrasena'] !== $data['contrasena']) {
            return redirect()->route('autenticacion.loginView')
                ->withInput()
                ->with('error', 'Acceso no permitido');
        }

        // Genera la cookie de autenticación (24 horas).
        service('response')->setCookie('userAuth', $user[$primaryKeyFieldName], 60 * 60 * 24);

        return redirect()->route('movimientos.index')->withCookies();
    }

    // Cierra la sesión de un usuario.
    public function logoutAction()
    {
        service('response')->deleteCookie('userAuth');

        return redirect()->route('autenticacion.loginView')->withCookies();
    }
}
