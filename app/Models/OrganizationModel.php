<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationModel extends Model
{
    public function insertData($data)
    {
        return $this->db->table('tbl_organizations')->insert($data);
    }

    public function getData()
    {
        return $this->db->table('tbl_organizations')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResult();
    }

    public function getDataById($id)
    {

        return $this->db->table('tbl_organizations')
            ->join('tbl_states', 'tbl_states.id = tbl_organizations.state_id', 'inner')
            ->join('tbl_districts', 'tbl_districts.id = tbl_organizations.district_id', 'inner')
            ->join('tbl_blocks', 'tbl_blocks.id = tbl_organizations.block_id', 'inner')
            ->select('tbl_states.id as states_id,
                        tbl_states.name as states_name,
                        tbl_districts.id AS district_id, 
                        tbl_districts.name AS district_name ,
                        tbl_blocks.id as block_id,
                        tbl_blocks.name as block_name,
                        tbl_organizations.*')
            ->where('tbl_organizations.id', $id)
            ->get()
            ->getRow();
    }

    public function updateData($data, $id)
    {
        return $this->db->table('tbl_organizations')->where('id', $id)->update($data);
    }

    public function deleteData($id)
    {
        return $this->db->table('tbl_organizations')->where('id', $id)->delete();
    }


    public function fetchDistricts($id = NULL)
    {
        try {
            $query = $this->db->table('tbl_districts');

            $result = $query->where('state_id', $id)->get()->getResultArray();

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

    public function fetchBlocks($id = NULL)
    {
        try {
            $query = $this->db->table('tbl_blocks');

            $result = $query->where('district_id', $id)->get()->getResultArray();

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
