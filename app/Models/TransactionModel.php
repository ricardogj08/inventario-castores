<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo que representa la tabla de movimientos de los productos.
class TransactionModel extends Model
{
    protected $table = 'movimientos';

    // protected $primaryKey       = 'id';
    protected $primaryKey             = 'idMovimiento';
    protected $useAutoIncrement       = true;
    protected $returnType             = 'array';
    protected $useSoftDeletes         = false;
    protected $protectFields          = true;
    protected $allowedFields          = ['idProducto', 'idTipoMovimiento', 'idUsuario', 'cantidad'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected array $casts            = [];
    protected array $castHandlers     = [];

    // Dates
    // protected $useTimestamps = false;
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';

    // protected $createdField  = 'created_at';
    protected $createdField = 'fecha_registro';

    // protected $updatedField  = 'updated_at';
    protected $updatedField = 'fecha_modificacion';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Relaciona la tabla de productos.
    public function product()
    {
        return $this->join('productos', 'movimientos.idProducto = productos.idProducto', 'inner');
    }

    // Relaciona la tabla de tipos de movimientos de los productos.
    public function type()
    {
        return $this->join('tipos_movimientos', 'movimientos.idTipoMovimiento = tipos_movimientos.idTipoMovimiento', 'inner');
    }

    // Relaciona la tabla de usuarios.
    public function user()
    {
        return $this->join('usuarios', 'movimientos.idUsuario = usuarios.idUsuario', 'inner');
    }
}
