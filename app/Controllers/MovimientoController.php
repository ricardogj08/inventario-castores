<?php

namespace App\Controllers;

use App\Models\MovimientoModel;

class MovimientoController extends BaseController
{
    // Renderiza la página de todos los movimientos de los productos.
    public function index()
    {
        $movimientoModel = model(MovimientoModel::class);

        $movimientoTableName = $movimientoModel->table;

        $query = $movimientoModel->select("{$movimientoTableName}.{$movimientoModel->primaryKey} As id, {$movimientoModel->getProductoTableName()}.nombre AS producto, {$movimientoTableName}.cantidad, {$movimientoModel->getTipoMovimientoTableName()}.nombre AS tipo, {$movimientoModel->getUsuarioTableName()}.nombre AS usuario, {$movimientoTableName}.fecha_registro")
            ->producto()
            ->tipo()
            ->usuario();

        // Consulta todos los movimientos.
        $transactions = $query->orderBy("{$movimientoTableName}.fecha_registro", 'DESC')->findAll();

        $data = compact('transactions');

        return view('movimientos/index', $data);
    }
}
