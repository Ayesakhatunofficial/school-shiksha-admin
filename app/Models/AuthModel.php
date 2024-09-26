<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    /**
     * Get user details by username or email
     * @param string $username
     * @return object
     */
    public function auth($username)
    {
        return $this->db->table('tbl_users')->where('email', $username)
            ->get()
            ->getRow();
    }

    /**
     * update data
     * 
     * @param array $data
     * @param string $email
     * @return bool
     */
    public function updateData($data, $email)
    {
        return $this->db->table('tbl_users')
            ->where('email', $email)
            ->update($data);
    }

    /**
     * Verify token for reset password 
     * 
     * @param string $token
     * @return object
     */
    public function verifyToken($token)
    {
        return $this->db->table('tbl_users')
            ->where('reset_token', $token)
            ->get()
            ->getRow();
    }

    /**
     * Update reset password
     * 
     * @param array $input
     * @return bool  
     */
    public function updatePassword($input)
    {
        $data = [
            'password' => md5($input['new_password']),
            'raw_password' => $input['new_password'],
            'reset_token' => NULL
        ];

        $email = session()->get('email');

        return $this->db->table('tbl_users')
            ->where('email', $email)
            ->update($data);
    }
}
