<?php

namespace App\Models;

use CodeIgniter\Model;

class BlocksModel extends Model
{
    protected $table = 'tbl_blocks';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['district_id', 'name', 'is_active', 'created_by', 'updated_by'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getData()
    {
        return $this->table('tbl_blocks')
            ->join('tbl_districts', 'tbl_districts.id = tbl_blocks.district_id', 'inner')
            ->join('tbl_states', 'tbl_states.id = tbl_districts.state_id')
            ->select('tbl_districts.id AS district_id, 
        tbl_districts.name AS district_name ,
        tbl_states.name AS state_name,
        tbl_blocks.id as block_id,
        tbl_blocks.name as block_name,
        tbl_blocks.is_active')
            ->orderBy('tbl_blocks.id', 'DESC')
            ->get()
            ->getResultArray();
    }
}
