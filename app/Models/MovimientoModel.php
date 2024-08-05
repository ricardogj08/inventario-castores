<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo que representa la tabla de movimientos de los productos.
class MovimientoModel extends Model
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
    protected $updatedField = '';
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
}
