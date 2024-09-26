<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'tbl_carrier_guidlines';
    protected $primaryKey = 'id';

    // Specify the columns that can be queried
    protected $allowedFields = [
        'id', 'name', 'email', 'mobile', 'guardian_name', 'whatsapp_number',
        'mp_percentage', 'hs_percentage', 'stream', 'interest_course_name', 'created_at'
    ];

    /**
     * Get total agent 
     * 
     * @param string $from_date
     * @param string $to_date
     * @return object
     */
    public function getAgent($from_date, $to_date)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        $role_id = getRoleId(ROLE_AFFILATE_AGENT);

        if ($role == ROLE_SUPER_ADMIN) {

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' ";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            }
            return $this->db->query($sql)->getRow();
        } else if ($role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR) {

            $distributor_id = getUserId($user->id);

            $md_id[] = $user->id;

            if (!empty($distributor_id)) {
                $all_id = array_merge($distributor_id, $md_id);
            } else {
                $all_id = $md_id;
            }
            $merge = '(' . implode(', ', $all_id) . ')';

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'
                        AND created_by IN $merge";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        AND created_by IN $merge";
            }
            return $this->db->query($sql)->getRow();
        }
    }

    /**
     * Get total active agent 
     * 
     * @param string $from_date
     * @param string $to_date
     * @return object
     */
    public function getActiveAgent($from_date, $to_date)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        $role_id = getRoleId(ROLE_AFFILATE_AGENT);

        if ($role == ROLE_SUPER_ADMIN) {

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_active_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' ";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_active_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            }
            return $this->db->query($sql)->getRow();
        } else if ($role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR) {

            $distributor_id = getUserId($user->id);

            $md_id[] = $user->id;

            if (!empty($distributor_id)) {
                $all_id = array_merge($distributor_id, $md_id);
            } else {
                $all_id = $md_id;
            }
            $merge = '(' . implode(', ', $all_id) . ')';

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_active_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'
                        AND created_by IN $merge";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_active_agent
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        AND created_by IN $merge";
            }
            return $this->db->query($sql)->getRow();
        }
    }

    /**
     * Get total master distributor
     * 
     * @param string $from_date
     * @param string $to_date
     * @return object
     */
    public function getMasterDistributor($from_date, $to_date)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        $role_id = getRoleId(ROLE_MASTER_DISTRIBUTOR);


        if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

            $sql = "SELECT 
                            COUNT(id) as total_master_distributor
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'";
        } else {
            $sql = "SELECT 
                            COUNT(id) as total_master_distributor
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
        }

        return $this->db->query($sql)->getRow();
    }

    /**
     * Get total distributor
     * 
     * @param string $from_date
     * @param string $to_date
     * @return object
     */
    public function getDistributor($from_date, $to_date)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        $role_id = getRoleId(ROLE_DISTRIBUTOR);

        if ($role == ROLE_SUPER_ADMIN) {

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_distributor
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' ";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_distributor
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            }
            return $this->db->query($sql)->getRow();
        } else if ($role == ROLE_MASTER_DISTRIBUTOR) {

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_distributor
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'
                        AND created_by = $user->id";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_distributor
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        AND created_by = $user->id";
            }
            return $this->db->query($sql)->getRow();
        }
    }

    /**
     * Get total student
     * 
     * @param string $from_date
     * @param string $to_date
     * @return object
     */
    public function getStudent($from_date, $to_date)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        $role_id = getRoleId(ROLE_STUDENT);

        if ($role == ROLE_SUPER_ADMIN) {

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' ";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            }
            return $this->db->query($sql)->getRow();
        } else if ($role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR || $role == ROLE_AFFILATE_AGENT) {

            $users_id = $this->getSubordinateUsers($user->id);
            // print_r($all_id);
            // die;

            $id[] = $user->id;

            if (!empty($users_id)) {
                $all_id = array_merge($users_id, $id);
            } else {
                $all_id = $id;
            }
            $merge = '(' . implode(', ', $all_id) . ')';

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'
                        AND created_by IN $merge";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        AND created_by IN $merge";
            }
            return $this->db->query($sql)->getRow();
        }
    }

    /**
     * Get total users id
     * 
     * @param int $user_id
     * @return object|array
     */
    public function getSubordinateUsers($user_id)
    {
        $sql = "SELECT * FROM tbl_users WHERE created_by = $user_id";
        $result = $this->db->query($sql)->getResult();

        $ids = array();

        foreach ($result as $user) {
            $ids[] = $user->id;
        }

        foreach ($result as $user) {
            $ids = array_merge($ids, $this->getSubordinateUsers($user->id));
        }

        return $ids;
    }

    /**
     * Get total active student 
     * 
     * @param string $from_date
     * @param string $to_date
     * @return object
     */
    public function getActiveStudent($from_date, $to_date)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        $role_id = getRoleId(ROLE_STUDENT);

        if ($role == ROLE_SUPER_ADMIN) {

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_active_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id
                        AND is_active = 1 AND DATE(created_at) BETWEEN '$from_date' AND '$to_date' ";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_active_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
            }
            return $this->db->query($sql)->getRow();
        } else if ($role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_MASTER_DISTRIBUTOR || $role == ROLE_DISTRIBUTOR || $role == ROLE_AFFILATE_AGENT) {

            $users_id = $this->getSubordinateUsers($user->id);

            $id[] = $user->id;

            if (!empty($users_id)) {
                $all_id = array_merge($users_id, $id);
            } else {
                $all_id = $id;
            }
            $merge = '(' . implode(', ', $all_id) . ')';

            if (!is_null($to_date) && !is_null($from_date) && $to_date != '' && $from_date != '') {

                $sql = "SELECT 
                            COUNT(id) as total_active_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND DATE(created_at) BETWEEN '$from_date' AND '$to_date'
                        AND created_by IN $merge";
            } else {
                $sql = "SELECT 
                            COUNT(id) as total_active_student
                        FROM 
                            tbl_users
                        WHERE role_id = $role_id AND is_active = 1 AND  DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                        AND created_by IN $merge";
            }

            return $this->db->query($sql)->getRow();
        }
    }

    /**
     * Get  student query
     * 
     * @return array
     */
    public function studentQuery()
    {
        try {
            $query = $this->db->table('tbl_queries');

            $result = $query->get()->getResultArray();

            if ($result) {
                return $result; // Return the fetched rows
            } else {
                return []; // Return an empty array if no rows found
            }
        } catch (\Exception $e) {
            error_log('Error fetching query: ' . $e->getMessage());
            return false; // Return false or appropriate value to indicate failure
        }
    }


    /**
     * Get  Career Guidence
     * 
     * @return array
     */
    public function careerGuidenceData($start, $length, $searchValue)
    {
        $builder = $this->table($this->table);
        $builder->select('name, email, mobile, id'); // Ensure 'id' is selected for creating the action URL

        // Search
        if ($searchValue) {
            $builder->groupStart()
                ->like('name', $searchValue)
                ->orLike('email', $searchValue)
                ->orLike('mobile', $searchValue)
                ->groupEnd();
        }

        // Order by created_at in descending order
        $builder->orderBy('created_at', 'DESC');

        // Pagination
        $builder->limit($length, $start);

        // Fetch data
        $query = $builder->get();
        $data = $query->getResultArray();

        // Add action column
        foreach ($data as &$row) {
            $row['action'] = '
            <a href="' . base_url('/careerGuidence/view/' . $row['id']) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                <i class="mdi mdi-eye"></i>
            </a>
        ';
        }


        return $data;
    }


    public function countAllData()
    {
        return $this->countAll();
    }

    public function countFilteredData($searchValue)
    {
        $builder = $this->table($this->table);

        if ($searchValue) {
            $builder->groupStart()
                ->like('name', $searchValue)
                ->orLike('email', $searchValue)
                ->orLike('guardian_name', $searchValue)
                ->orLike('mobile', $searchValue)
                ->orLike('whatsapp_number', $searchValue)
                ->orLike('stream', $searchValue)
                ->orLike('interest_course_name', $searchValue)
                ->groupEnd();
        }

        return $builder->countAllResults();
    }

    /**
     * Get  Career Guidence
     * 
     * @param int $id
     * @return object
     */
    public function careerGuidenceSingleData($id = NULL)
    {
        if ($id === NULL) {
            return NULL;
        }
        return $this->db->table('tbl_carrier_guidlines')
            ->where('id', $id)
            ->get()
            ->getRow();
    }

    /**
     * Get external records
     * 
     * @param string $query
     * @return array[object]
     */
    public function getExternalRecords($query)
    {
        return $this->db->query($query)->getResult();
    }

    /**
     * Get Banner data by user role id
     * 
     * @return array[object]
     */
    public function getBanners()
    {
        $user = getUserData();
        $role_id = $user->role_id;

        $sql = "SELECT 
                    *
                FROM 
                    tbl_dashboard_banners 
                WHERE role_id = ? ";

        return $this->db->query($sql, [$role_id])->getResult();
    }
}
