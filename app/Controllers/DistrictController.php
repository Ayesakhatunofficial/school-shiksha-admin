<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DistrictModel;

class DistrictController extends BaseController
{
    protected $districtModel;
    protected $session;

    public function __construct()
    {
        // Load DistrictModel using dependency injection
        $this->districtModel = new DistrictModel();
        // Get session instance
        // $this->session = session();
        // $this->session->set('meta', "Add Course");
    }
    public function district()
    {
        $data['district'] = $this->districtModel->findAll();
        $data['district'] = $this->districtModel->table('tbl_districts')
            ->join('tbl_states', 'tbl_states.id = tbl_districts.state_id', 'inner')
            ->select('tbl_states.id AS states_id, tbl_states.name as states_name , tbl_districts.*')
            ->orderBy('tbl_districts.id', 'DESC')
            ->get()
            ->getResultArray();
        return view(
            'district/view',
            $data
        );
    }

    public function editDistrict($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->to('district')->with('error', 'Invalid district ID.');
        }
        $district = $this->districtModel->find($id);

        if (!$district) {
            return redirect()->to('district')->with('error', 'District not found.');
        }
        $states = $this->districtModel->fetchStates();
        return view('district/edit', [
            'district' => $district,
            'states' => $states,
        ]);
    }


    public function addDistrict()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();

            $data = $this->request->getPost();

            $data['created_by'] =   $user->id;
            $response = $this->districtModel->where('name',  $data['name'])->first();

            if (!empty($response)) {
                return redirect()->back()->with('error', 'District name already exists !');
            }

            if ($this->districtModel->insert($data)) {
                return redirect()->to('district')->with('msg', 'District inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('district/add', ['states' =>  $this->districtModel->fetchStates()]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();
            $id = $this->request->getPost('hidden_id');
            $data = $this->request->getPost();
            $data['updated_by'] =   $user->id;
            if ($this->districtModel->update($id, $data)) {
                return redirect()->to('district')->with('msg', 'District updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('district/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->districtModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('district')->with('msg', $msg);
    }
}
