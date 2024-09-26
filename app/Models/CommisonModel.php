<?php

namespace App\Models;

use CodeIgniter\Model;

class CommisonModel extends Model
{
    protected $table            = 'tbl_service_comissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_id', 'service_id', 'amount'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

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

    public function fetchRoles()
    {
        try {
            $role = ROLE_AFFILATE_AGENT;

            return $this->db->table('tbl_roles')
                ->where('role_name', $role)
                ->get()
                ->getResultArray();
        } catch (\Exception $e) {
            error_log('Error fetching roles: ' . $e->getMessage());
            return false; // Return false or appropriate value to indicate failure
        }
    }
}
