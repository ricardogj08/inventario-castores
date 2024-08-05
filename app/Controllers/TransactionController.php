<?php

namespace App\Controllers;

use App\Models\MovimientoModel;
use App\Models\TipoMovimientoModel;

class TransactionController extends BaseController
{
    private function getSearchValidationRules()
    {
        return [
            'search[idTipoMovimiento]' => 'permit_empty|is_natural_no_zero|is_not_unique[tipos_movimientos.idTipoMovimiento]',
        ];
    }

    // Renderiza la página de todos los movimientos de los productos.
    public function index()
    {
        $transactionModel = model(MovimientoModel::class);

        $query = $transactionModel->select('movimientos.idMovimiento, productos.nombre AS producto, movimientos.cantidad, tipos_movimientos.nombre AS tipo, usuarios.nombre AS usuario, movimientos.fecha_registro, movimientos.fecha_modificacion')
            ->producto()
            ->tipo()
            ->usuario();

        $rules = $this->getSearchValidationRules();

        $filters = $this->request->getGet(array_keys($rules));

        if (! empty($filters['search[idTipoMovimiento]'])) {
            $query->where('movimientos.idTipoMovimiento', $filters['search[idTipoMovimiento]']);
        }

        // Consulta todos los movimientos.
        $transactions = $query->orderBy('movimientos.fecha_registro', 'DESC')->findAll();

        $transactionTypeModel = model(TipoMovimientoModel::class);

        // Consulta la información de todos los tipos de movimientos.
        $typesTransactions = $transactionTypeModel->select('idTipoMovimiento, nombre')
            ->orderBy('nombre', 'ASC')
            ->findAll();

        $data = compact('transactions', 'typesTransactions');

        helper('form');

        return view('transactions/index', $data);
    }
}
