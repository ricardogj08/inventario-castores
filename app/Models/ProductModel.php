<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo que representa la tabla de productos.
class ProductModel extends Model
{
    protected $table = 'productos';

    // protected $primaryKey             = 'id';
    protected $primaryKey             = 'idProducto';
    protected $useAutoIncrement       = true;
    protected $returnType             = 'array';
    protected $useSoftDeletes         = false;
    protected $protectFields          = true;
    protected $allowedFields          = ['nombre', 'precio', 'cantidad', 'estatus'];
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
}
