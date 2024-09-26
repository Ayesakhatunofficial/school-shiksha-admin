<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'tbl_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['setting_name', 'setting_value'];

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

    public function settingData($id = NULL)
    {
        if ($id === NULL) {
            return $this->db->table('tbl_settings')->select('*')->get()->getResultArray();
        } else {
            return $this->db->table('tbl_settings')->select('*')->where('tbl_settings.id', $id)->get()->getRowArray();
        }
    }
    public function settingUpdate($data)
    {
        $result = false;

        if (!empty($data)) {
            foreach ($data as $key => $row) {
                $result = $this->db->table('tbl_settings')
                    ->where('setting_name', $key)
                    ->update(['setting_value' => $row]);
            }
            // Return true or any other result as needed
            return  $result;
        }

        // Return false or handle the case when $data is empty
        return  $result;
    }
}
