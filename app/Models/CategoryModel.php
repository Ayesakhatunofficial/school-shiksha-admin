<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    public function insertData($data)
    {
        $result = $this->db->table('tbl_services')->insert($data);
        if ($result) {
            return $this->db->insertID();
        } else {
            return false;
        }
    }

    public function getData()
    {
        return $this->db->table('tbl_services')->get()->getResult();
    }

    public function getactiveService()
    {
        return $this->db->table('tbl_services')->where('is_active', '1')->get()->getResult();
    }

    public function getDataById($id)
    {
        return $this->db->table('tbl_services')->where('id', $id)->get()->getRow();
    }

    public function updateData($data, $id)
    {
        return $this->db->table('tbl_services')->where('id', $id)->update($data);
    }

    public function deleteData($id)
    {
        return $this->db->table('tbl_services')->where('id', $id)->delete();
    }

    public function getArrayDataById($id)
    {
        return $this->db->table('tbl_services')->where('id', $id)->get()->getResultArray();
    }

    public function insert_org_courses($id = NULL, $org_course_id = [])
    {
        if (!empty($org_course_id)) {

            foreach ($org_course_id as $course_id) {
                $data = [
                    'service_id' => $id,
                    'org_course_id' => $course_id
                ];

                $this->db->table('tbl_course_services')->insert($data);
            }
            // Return true if insertion is successful
            return true;
        }
        // Return false or handle the case when $service_ids is empty
        return false;
    }
    public function delete_org_courses($id = NULL)
    {
        if (!is_null($id)) {
            $this->db->table('tbl_course_services')->where('service_id', $id)->delete();
            // Return the number of affected rows
            return $this->db->affectedRows();
        }

        // Return 0 if $id is NULL
        return 0;
    }

    public function _course_service($id = NULL)
    {
        try {
            $query = $this->db->table('tbl_course_services');

            $result = $query->where('service_id', $id)->get()->getResultArray();

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
