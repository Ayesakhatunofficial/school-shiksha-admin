<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\StatesModel;

class StatesController extends BaseController
{
    protected $StatesModel;
    protected $session;

    public function __construct()
    {
        $this->StatesModel = new StatesModel();
    }
    public function states()
    {
        $data['states'] = $this->StatesModel->orderBy('id', 'DESC')->findAll();
        return view(
            'states/view',
            $data
        );
    }

    public function editState($id = NULL)
    {
        // Check if $id is provided and is a valid integer
        if ($id === NULL || !is_numeric($id)) {
            // Handle invalid ID (e.g., show error message or redirect)
            return redirect()->to('states')->with('error', 'Invalid district ID.');
        }

        // Retrieve district data by ID from the district model
        $district = $this->StatesModel->find($id);

        // Check if district with the given ID was found
        if (!$district) {
            // Handle district not found (e.g., show error message or redirect)
            return redirect()->to('states')->with('error', 'States not found.');
        }
        // Pass the retrieved district data to the edit view
        return view('states/edit', [
            'states' => $district
        ]);
    }


    public function addState()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();

            $data = $this->request->getPost();

            $data['created_by'] = $user->id;
            $response = $this->StatesModel->where('name', $data['name'])->first();

            if (!empty($response)) {
                return redirect()->back()->with('error', 'States name already exists !');
            }

            if ($this->StatesModel->insert($data)) {
                return redirect()->to('states')->with('msg', 'States inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('states/add');
    }

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();
            $id = $this->request->getPost('hidden_id');

            $data = $this->request->getPost();

            $response = $this->StatesModel->where('id !=', $id)->where('name', $data['name'])->first();

            if (!empty($response)) {
                return redirect()->back()->with('error', 'States name already exists !');
            }

            $data['updated_by'] = $user->id;
            if ($this->StatesModel->update($id, $data)) {
                return redirect()->to('states')->with('msg', 'States updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('states/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->StatesModel->delete($id);

        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('states')->with('msg', $msg);
    }
}
