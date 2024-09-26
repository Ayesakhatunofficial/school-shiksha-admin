<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CommisonModel;
use App\Models\CategoryModel;

class CommisionController extends BaseController
{
    protected $CommisonModel;
    protected $Service;

    public function __construct()
    {
        $this->CommisonModel = new CommisonModel();
        $this->Service = new CategoryModel();
    }
    public function commission()
    {
        $data['plans'] = $this->CommisonModel->table('tbl_service_comissions')
            ->join('tbl_roles', 'tbl_roles.id = tbl_service_comissions.role_id', 'inner')
            ->join('tbl_services', 'tbl_services.id = tbl_service_comissions.service_id	', 'inner')
            ->select('tbl_roles.role_name, tbl_services.service_name, tbl_service_comissions.*')
            ->orderBy('tbl_service_comissions.id', 'DESC')
            ->get()
            ->getResultArray();

        return view(
            'commision/view',
            $data
        );
    }

    public function editCommission($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->to('commsion')->with('error', 'Invalid plans ID.');
        }

        $commison = $this->CommisonModel->find($id);

        if (!$commison) {
            return redirect()->to('commsion')->with('error', 'Commission not found.');
        }
        $roles = $this->CommisonModel->fetchRoles();
        return view('commision/edit', [
            'commison' => $commison,
            'roles' => $roles,
            'service' => $this->Service->getData()
        ]);
    }

    public function addCommission()
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getPost();

            if ($this->CommisonModel->insert($data)) {
                return redirect()->to('commsion')->with('msg', 'Commission inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('commision/add', [
            'roles' => $this->CommisonModel->fetchRoles(),
            'service' => $this->Service->getData()
        ]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $data = $this->request->getPost();
            if ($this->CommisonModel->update($id, $data)) {
                return redirect()->to('commsion')->with('msg', 'Commission updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('commision/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->CommisonModel->delete($id);
        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('commsion')->with('msg', $msg);
    }
}
