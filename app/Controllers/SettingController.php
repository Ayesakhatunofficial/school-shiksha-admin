<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SettingModel;

class SettingController extends BaseController
{

    public function index()
    {
        $SettingModel = new SettingModel();
        $data['setting'] = $SettingModel->settingData();
        return view('setting/edit_setting.php', $data);
    }

    public function edit()
    {
        // Assuming $session is an instance of SessionInterface injected into your controller
        $session = \Config\Services::session();

        $SettingModel = new SettingModel();
        $data = $this->request->getPost();
        $img = $this->request->getFile('company_logo');

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Update the data array with the new image name
            $data['company_logo'] =  uploadFile($img);;
            // Set session variable 'logo' with the new image name
            $session->set('logo', $data['company_logo']['file_name']);
        }
        $result = $SettingModel->settingUpdate($data);

        if ($result !== false) {
            return redirect()->to('setting')->with('msg', 'Settings updated successfully!');
        } else {
            return redirect()->to('setting')->with('msg', 'Something went wrong!');
        }
    }
}
