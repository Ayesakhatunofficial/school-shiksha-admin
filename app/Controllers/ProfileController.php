<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function index()
    {
        $UserModel = new UserModel();
        $userId = session('user');
        $data['profile'] = $UserModel->find($userId->id);

        $role_id = $data['profile']['role_id'];

        $data['role'] = getRole($role_id);

        // print_r($data['profile']);
        // die;
        return view('profile/edit_profile.php', $data);
    }

    public function edit($id = NULL)
    {
        $session = session();

        $UserModel = new UserModel();
        $data = $this->request->getPost();

        $emailResponse = $UserModel->where('id !=', $id)->where('email', $data['email'])->countAllResults();

        $mobileResponse = $UserModel->where('id !=', $id)->where('mobile', $data['mobile'])->countAllResults();

        if ($emailResponse > 0) {
            return redirect()->back()->with('error', 'A user with the provided email already exists.');
        }

        if ($mobileResponse > 0) {
            return redirect()->back()->with('error', 'A user with the provided mobile number already exists.');
        }

        if (isset($data['password']) && $data['password'] != "") {
            $data['raw_password'] = $data['password'];
            $data['password'] = md5($data['password']);
        } else {
            unset($data['password']);
        }

        $result = $UserModel->update($id, $data);

        if ($result) {
            $user = $UserModel->getUserById($id);
            if ($user) {
                $session->remove('user');
                $s_data = [
                    'user' => $user
                ];
                $session->set($s_data);
            }
        }

        if ($result !== false) {
            return redirect()->to('profile')->with('msg', 'Profile updated successfully!');
        } else {
            return redirect()->back()->with('msg', 'Something went wrong!');
        }
    }
}
