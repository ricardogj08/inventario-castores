<?php

namespace App\Filters;

use App\Models\UsuarioModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

// Valida si un usuario está autenticado.
class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param array|null $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtiene la cookie del usuario autenticado.
        $cookie = $request->getCookie('userAuth');

        if (empty($cookie)) {
            return redirect()->route('autenticacion.loginView')
                ->with('warning', 'Ingresa tus credenciales de acceso');
        }

        $usuarioModel = model(UsuarioModel::class);

        $usuarioTableName = $usuarioModel->table;

        // Consulta la información del usuario autenticado.
        $userAuth = $usuarioModel->select("{$usuarioTableName}.{$usuarioModel->primaryKey} AS id, {$usuarioTableName}.nombre, {$usuarioModel->getRolTableName()}.nombre AS rol")
            ->rol()
            ->where("{$usuarioTableName}.estatus", 1)
            ->find($cookie);

        // Roles permitidos en la aplicación.
        $allowedRoles = ['Administrador', 'Almacenista'];

        if (empty($userAuth) || ! in_array($userAuth['rol'], $allowedRoles, true)) {
            return redirect()->route('autenticacion.loginView')
                ->with('error', 'Acceso denegado al sistema');
        }

        // Almacena la información del usuario durante la sesión.
        session()->set('userAuth', $userAuth);
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param array|null $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
