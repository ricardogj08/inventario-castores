<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionTypeModel;

class TransactionController extends BaseController
{
    // Reglas de validación de filtrado.
    private function getSearchValidationRules()
    {
        return [
            'search[idTipoMovimiento]' => 'permit_empty|is_natural_no_zero|is_not_unique[tipos_movimientos.idTipoMovimiento]',
        ];
    }

    // Renderiza la página de todos los movimientos de los productos.
    public function index()
    {
        $transactionModel = model(TransactionModel::class);

        $query = $transactionModel->select('movimientos.idMovimiento, productos.nombre AS producto, movimientos.cantidad, tipos_movimientos.nombre AS tipo, usuarios.nombre AS usuario, movimientos.fecha_registro, movimientos.fecha_modificacion')
            ->product()
            ->type()
            ->user();

        $rules = $this->getSearchValidationRules();

        $filters = $this->request->getGet(array_keys($rules));

        // Valida los campos de filtrado.
        if (! $this->validateData($filters, $rules)) {
            return redirect()->route('transactions.index');
        }

        // Filtra los resultados por tipo de movimiento.
        if (! empty($filters['search[idTipoMovimiento]'])) {
            $query->where('movimientos.idTipoMovimiento', $filters['search[idTipoMovimiento]']);
        }

        // Consulta todos los movimientos.
        $transactions = $query->orderBy('movimientos.fecha_registro', 'DESC')->findAll();

        $transactionTypeModel = model(TransactionTypeModel::class);

        // Consulta la información de todos los tipos de movimientos.
        $typesTransactions = $transactionTypeModel->select('idTipoMovimiento, nombre')
            ->orderBy('nombre', 'ASC')
            ->findAll();

        $data = compact('transactions', 'typesTransactions', 'filters');

        helper('form');

        return view('transactions/index', $data);
    }
}
