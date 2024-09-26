<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\BlocksModel;
use App\Models\DistrictModel;
use App\Models\StatesModel;

class BlocksController extends BaseController
{
    protected $BlocksModel;
    protected $DistrictModel;
    protected $session;
    protected $StatesModel;

    public function __construct()
    {
        $this->BlocksModel = new BlocksModel();
        $this->DistrictModel = new DistrictModel();
        $this->StatesModel = new StatesModel();
    }
    public function blocks()
    {
        $data['blocks'] = $this->BlocksModel->getData();

        return view(
            'blocks/view',
            $data
        );
    }

    public function editBlocks($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->to('blocks')->with('error', 'Invalid blocks ID.');
        }

        $blocks = $this->BlocksModel->table('tbl_blocks')
            ->join('tbl_districts', 'tbl_districts.id = tbl_blocks.district_id', 'inner')
            ->join('tbl_states', 'tbl_states.id = tbl_districts.state_id')
            ->select('tbl_districts.id AS district_id, 
    tbl_districts.name AS district_name ,
    tbl_states.id AS state_id,
    tbl_states.name AS state_name,
    tbl_blocks.*')
            ->where('tbl_blocks.id', $id)
            ->orderBy('tbl_blocks.id', 'DESC')
            ->get()
            ->getRowArray();

        if (!$blocks) {
            return redirect()->to('blocks')->with('error', 'blocks not found.');
        }
        return view('blocks/edit', [
            'blocks' => $blocks,
            'district' => $this->DistrictModel->findAll(),
            'states' =>  $this->StatesModel->findAll()
        ]);
    }


    public function addBlocks()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();

            $data = $this->request->getPost();

            $data['created_by'] = $user->id;
            $response = $this->BlocksModel->where('name', $data['name'])->first();

            if (!empty($response)) {
                return redirect()->back()->with('error', 'Blocks name already exists !');
            }

            if ($this->BlocksModel->insert($data)) {
                return redirect()->to('blocks')->with('msg', 'Blocks inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }

        return view('blocks/add', [
            'states' =>  $this->StatesModel->findAll()
        ]);
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();
            $id = $this->request->getPost('hidden_id');
            $data = $this->request->getPost();
            $data['updated_by'] = $user->id;

            $response = $this->BlocksModel->where('id !=', $id)->where('name',  $data['name'])->first();

            if (!empty($response)) {
                return redirect()->back()->with('error', 'Block name already exists !');
            }

            if ($this->BlocksModel->update($id, $data)) {
                return redirect()->to('blocks')->with('msg', 'Blocks updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('blocks/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->BlocksModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('district')->with('msg', $msg);
    }

    public function fetchUser()
    {
        $id = $this->request->getPost('role_id');

        $result =  $this->DistrictModel->where('state_id', $id)->where('is_active', 1)->get()->getResultArray();
        // Start building the options HTML
        $options = '';
        $options = '<option value="">--Select--</option>';
        if ($result) {
            foreach ($result as $row) {
                // Concatenate each option to the $options string
                $options .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
            return $options;
        } else {
            return $options;
        }
    }
}
