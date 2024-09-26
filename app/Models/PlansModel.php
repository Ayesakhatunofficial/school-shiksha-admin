<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;

class PlansModel extends Model
{
    protected $table = 'tbl_plans';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['role_id', 'plan_name', 'plan_amount', 'plan_duration', 'plan_description', 'is_active'];

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

    public function fetchRoles()
    {
        try {
            $query = $this->db->table('tbl_roles')->where('role_name !=', 'super_admin');

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

    /**
     * Get role by role id 
     * 
     * @param int $id
     * @return object|array
     */
    public function fetchroleWithid($id)
    {
        try {
            $role = getRole($id);
            if ($role == ROLE_AFFILATE_AGENT) {
                $dis_role = ROLE_DISTRIBUTOR;
                $role_id = getRoleId($dis_role);
            } else if ($role == ROLE_DISTRIBUTOR) {
                $master_role = ROLE_MASTER_DISTRIBUTOR;
                $role_id = getRoleId($master_role);
            } else if ($role == ROLE_STUDENT) {
                $agent_role = ROLE_AFFILATE_AGENT;
                $role_id = getRoleId($agent_role);
            }

            $result = $this->db->table('tbl_roles')
                ->where('id', $role_id)
                ->get()
                ->getRow();

            if ($result) {
                return $result;
            } else {
                return [];
            }
        } catch (\Exception $e) {
            return false;
        }
    }
    public function insert_plan_services($id = NULL, $service_ids = [])
    {
        if (!empty($service_ids)) {
            foreach ($service_ids as $service_id) {
                $data = [
                    'plan_id' => $id,
                    'service_id' => $service_id
                ];

                $this->db->table('tbl_plan_services')->insert($data);
            }
            return true;
        }
        return false;
    }
    public function delete_plan_services($id = NULL)
    {
        if (!is_null($id)) {
            $this->db->table('tbl_plan_services')->where('plan_id', $id)->delete();
            // Return the number of affected rows
            return $this->db->affectedRows();
        }

        // Return 0 if $id is NULL
        return 0;
    }

    public function insert_plan_commission($id = NULL, $data = [])
    {
        if (!empty($data)) {

            $datas = [
                'role_id' =>  $data['commission_role_id'],
                'plan_id' => $id,
                'amount' => $data['amount']
            ];

            $this->db->table('tbl_plan_commission')->insert($datas);

            // Return true if insertion is successful
            return true;
        }
        // Return false or handle the case when $service_ids is empty
        return false;
    }

    public function delete_plan_commission($id = NULL)
    {
        if (!is_null($id)) {
            $this->db->table('tbl_plan_commission')->where('plan_id', $id)->delete();
            // Return the number of affected rows
            return $this->db->affectedRows();
        }

        // Return 0 if $id is NULL
        return 0;
    }


    public function plan_service($id = NULL)
    {
        try {
            $query = $this->db->table('tbl_plan_services');

            $result = $query->where('plan_id', $id)->get()->getResultArray();

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

    public function _plan_commission($id = NULL)
    {
        try {
            $query = $this->db->table('tbl_plan_commission');

            $result = $query->where('plan_id', $id)->get()->getRowArray();

            if ($result) {
                return $result; // Return the fetched row as an associative array
            } else {
                return []; // Return an empty array if no row found
            }
        } catch (\Exception $e) {
            error_log('Error fetching plan commission: ' . $e->getMessage());
            return false; // Return false or appropriate value to indicate failure
        }
    }


    public function addPlanData($data)
    {
        try {
            $this->db->transException(true)->transStart();

            $plan_data = [
                'role_id' => $data['role_id'],
                'plan_name' => $data['plan_name'],
                'plan_amount' => $data['plan_amount'],
                'plan_duration' => $data['plan_duration'],
                'plan_description' => $data['plan_description'],
                'is_active' => $data['is_active']
            ];

            $this->db->table('tbl_plans')->insert($plan_data);
            $plan_id = $this->db->insertID();

            if (!empty($data['service_id'])) {
                foreach ($data['service_id'] as $service) {
                    $plan_services_data = [
                        'plan_id' => $plan_id,
                        'service_id' => $service
                    ];

                    $this->db->table('tbl_plan_services')->insert($plan_services_data);
                }
            }

            if ($data['commission_role_id'] != '' && $data['amount'] != '') {
                $commission_data = [
                    'role_id' => $data['commission_role_id'],
                    'plan_id' => $plan_id,
                    'amount' => $data['amount']
                ];

                $this->db->table('tbl_plan_commission')->insert($commission_data);
            }
            $this->db->transComplete();
            return true;
        } catch (DatabaseException $e) {
            return false;
        }
    }
}
