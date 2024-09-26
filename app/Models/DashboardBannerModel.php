<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardBannerModel extends Model
{
    protected $table            = 'tbl_dashboard_banners';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_id', 'title', 'banner', 'is_active'];

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
            // Use 'orWhere' to fetch roles that match either 'affiliate_agent' or 'student'
            $query = $this->db->table('tbl_roles')
                ->groupStart()
                ->where('role_name', 'affiliate_agent')
                ->orWhere('role_name', 'student')
                ->groupEnd();

            $result = $query->get()->getResultArray();

            if ($result) {
                return $result; // Return the fetched rows
            } else {
                return []; // Return an empty array if no rows found
            }
        } catch (\Exception $e) {
            error_log('Error fetching roles: ' . $e->getMessage());
            return false; // Return false or appropriate value to indicate failure
        }
    }
}
