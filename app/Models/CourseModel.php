<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    public function insertData($data)
    {
        return $this->db->table('tbl_courses')->insert($data);
    }

    public function getData()
    {
        return $this->db->table('tbl_courses')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();
    }

    public function getactiveCourse()
    {
        return $this->db->table('tbl_courses')->where('is_active', '1')->get()->getResult();
    }

    public function getDataById($id)
    {
        return $this->db->table('tbl_courses')
            ->where('id', $id)
            ->get()
            ->getRow();
    }

    public function updateData($data, $id)
    {
        return $this->db->table('tbl_courses')
            ->where('id', $id)
            ->update($data);
    }

    public function deleteData($id)
    {
        return $this->db
            ->table('tbl_courses')
            ->where('id', $id)
            ->delete();
    }
}
