<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo que representa la tabla de usuarios.
class UsuarioModel extends Model
{
    protected $table = 'usuarios';

    // protected $primaryKey = 'id';
    protected $primaryKey = 'idUsuario';

    // protected $useAutoIncrement       = true;
    protected $useAutoIncrement       = false;
    protected $returnType             = 'array';
    protected $useSoftDeletes         = false;
    protected $protectFields          = true;
    protected $allowedFields          = ['correo', 'idRol', 'nombre', 'contrasena', 'estatus'];
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
    protected array $casts            = [];
    protected array $castHandlers     = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    // Obtiene el nombre de la tabla de roles de los usuarios.
    public function getRolTableName()
    {
        return model(RolModel::class)->table;
    }

    // Obtiene el nombre de la llave primaria de la tabla de roles de los usuarios.
    public function getRolTablePrimaryKey()
    {
        return model(RolModel::class)->primaryKey;
    }

    // Relaciona la tabla de roles de los usuarios.
    public function rol()
    {
        $rolTableName = $this->getRolTableName();

        return $this->join($rolTableName, "{$this->table}.{$this->primaryKey} = {$rolTableName}.{$this->getRolTablePrimaryKey()}", 'inner');
    }
}
