<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'tbl_notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['user_id', 'subject', 'message', 'is_read'];

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


    /**
     * get roles except super admin 
     * 
     * @return array[array]
     */
    public function getRoles()
    {
        $sql = "SELECT 
                    *
                FROM 
                    tbl_roles
                WHERE role_name != 'super_admin' ";

        return $this->db->query($sql)->getResultArray();
    }

    /**
     * Get notification by id 
     * 
     * @param int $id
     * @return array
     */
    public function getNotificationById($id)
    {
        return $this->db->table('tbl_notifications')
            ->join('tbl_users', 'tbl_users.id = tbl_notifications.user_id', 'inner')
            ->select('tbl_users.id AS user_id,tbl_users.role_id,tbl_users.name, tbl_notifications.*')
            ->where('tbl_notifications.id', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Get class 
     * 
     * @return array[array]
     */
    public function getClass()
    {
        return $this->db->table('tbl_classes')
            ->get()
            ->getResultArray();
    }


    /**
     * Get student by class id
     * 
     * @param int $class_id
     * @return array[object]
     */
    public function getStudents($class_id)
    {
        $sql = "SELECT 
                    u.id as user_id,
                    u.name,
                    s.id
                FROM 
                tbl_students s 
                JOIN tbl_users u ON u.id = s.user_id
                WHERE s.class_id = ? ";

        return $this->db->query($sql, [$class_id])->getResult();
    }
}
