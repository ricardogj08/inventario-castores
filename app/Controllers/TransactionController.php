<?php

namespace App\Controllers;

use App\Models\MovimientoModel;
use App\Models\TipoMovimientoModel;

class TransactionController extends BaseController
{
    private function getSearchValidationRules()
    {
        $movimientoModel = model(MovimientoModel::class);

        return [
            'search[idTipoMovimiento]' => "permit_empty|is_natural_no_zero|is_not_unique[{$movimientoModel->getTipoMovimientoTableName()}.{$movimientoModel->getTipoMovimientoTablePrimaryKey()}]",
        ];
    }

    // Renderiza la página de todos los movimientos de los productos.
    public function index()
    {
        $movimientoModel = model(MovimientoModel::class);

        $movimientoTableName = $movimientoModel->table;

        $query = $movimientoModel->select("{$movimientoTableName}.{$movimientoModel->primaryKey} As id, {$movimientoModel->getProductoTableName()}.nombre AS producto, {$movimientoTableName}.cantidad, {$movimientoModel->getTipoMovimientoTableName()}.nombre AS tipo, {$movimientoModel->getUsuarioTableName()}.nombre AS usuario, {$movimientoTableName}.fecha_registro")
            ->producto()
            ->tipo()
            ->usuario();

        $rules = $this->getSearchValidationRules();

        $filters = $this->request->getGet(array_keys($rules));

        if (! empty($filters['search[idTipoMovimiento]'])) {
            $query->where("{$movimientoTableName}.idTipoMovimiento", $filters['search[idTipoMovimiento]']);
        }

        // Consulta todos los movimientos.
        $transactions = $query->orderBy("{$movimientoTableName}.fecha_registro", 'DESC')->findAll();

        $tipoMovimientoModel = model(TipoMovimientoModel::class);

        // Consulta la información de todos los tipos de movimientos.
        $typesTransactions = $tipoMovimientoModel->select("{$tipoMovimientoModel->primaryKey} AS id, nombre")
            ->orderBy('nombre', 'ASC')
            ->findAll();

        $data = compact('transactions', 'typesTransactions');

        helper('form');

        return view('transactions/index', $data);
    }
}
