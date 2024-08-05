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

    // Obtiene el nombre de la tabla de productos.
    public function getProductoTableName()
    {
        return model(ProductoModel::class)->table;
    }

    // Obtiene el nombre de la llave primaria de la tabla de productos.
    public function getProductoTablePrimaryKey()
    {
        return model(ProductoModel::class)->primaryKey;
    }

    // Relaciona la tabla de productos.
    public function producto()
    {
        $productoTableName = $this->getProductoTableName();

        return $this->join($productoTableName, "{$this->table}.idProducto = {$productoTableName}.{$this->getProductoTablePrimaryKey()}", 'inner');
    }

    // Obtiene el nombre de la tabla de tipos de movimientos de los productos.
    public function getTipoMovimientoTableName()
    {
        return model(TipoMovimientoModel::class)->table;
    }

    // Obtiene el nombre de la llave primaria de la tabla de tipos de movimientos de los productos.
    public function getTipoMovimientoTablePrimaryKey()
    {
        return model(TipoMovimientoModel::class)->primaryKey;
    }

    // Relaciona la tabla de tipos de movimientos de los productos.
    public function tipo()
    {
        $tipoMovimientoTableName = $this->getTipoMovimientoTableName();

        return $this->join($tipoMovimientoTableName, "{$this->table}.idTipoMovimiento = {$tipoMovimientoTableName}.{$this->getTipoMovimientoTablePrimaryKey()}", 'inner');
    }

    // Obtiene el nombre de la tabla de usuarios.
    public function getUsuarioTableName()
    {
        return model(UsuarioModel::class)->table;
    }

    // Obtiene el nombre de la llave primaria de la tabla de usuarios.
    public function getUsuarioTablePrimaryKey()
    {
        return model(UsuarioModel::class)->primaryKey;
    }

    // Relaciona la tabla de usuarios.
    public function usuario()
    {
        $usuarioTableName = $this->getUsuarioTableName();

        return $this->join($usuarioTableName, "{$this->table}.idUsuario = {$usuarioTableName}.{$this->getUsuarioTablePrimaryKey()}", 'inner');
    }
}
