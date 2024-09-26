<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PlansModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class PlansController extends BaseController
{
    protected $PlansModel;
    protected $session;
    protected $Service;
    protected $UserModel;
    protected $db;

    public function __construct()
    {
        $this->PlansModel = new PlansModel();
        $this->Service = new CategoryModel();
        $this->UserModel = new UserModel();
        $this->db = \Config\Database::connect();
    }
    public function plans()
    {
        $data['plans'] = $this->PlansModel->table('tbl_plans')
            ->join('tbl_roles', 'tbl_roles.id = tbl_plans.role_id', 'inner')
            ->select('tbl_roles.id AS role_id, tbl_roles.role_name, tbl_plans.*')
            ->orderBy('tbl_plans.id', 'DESC')
            ->get()
            ->getResultArray();

        return view(
            'plans/view',
            $data
        );
    }

    public function editPlans($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->to('plans')->with('error', 'Invalid plans ID.');
        }

        $plans = $this->PlansModel->find($id);
        $plan_service = $this->PlansModel->plan_service($id);
        $plan_commission = $this->PlansModel->_plan_commission($id);

        if (!$plans) {
            return redirect()->to('plans')->with('error', 'plans not found.');
        }
        $roles = $this->PlansModel->fetchRoles();
        return view('plans/edit', [
            'plans' => $plans,
            'roles' => $roles,
            'plan_service' => $plan_service,
            'service' => $this->Service->getData(),
            'comision' =>  $plan_commission
        ]);
    }

    public function addPlans()
    {
        if ($this->request->getMethod() === 'POST') {

            $data = $this->request->getPost();

            $data['plan_description'] = isset($data['plan_description']) ? json_encode($data['plan_description']) : "";

            $response = $this->PlansModel->where('plan_name', $data['plan_name'])->first();

            if (!empty($response)) {
                return redirect()->back()->withInput()->with('error', 'Plan name already exists!');
            }

            $result = $this->PlansModel->addPlanData($data);
            if ($result) {
                return redirect()->to('plans')->with('msg', 'Plan inserted successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Something went wrong!');
            }
        }

        return view('plans/add', [
            'roles' => $this->PlansModel->fetchRoles(),
            'service' => $this->Service->getData()
        ]);
    }


    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $data = $this->request->getPost();
            $data['plan_description'] = isset($data['plan_description']) ? json_encode($data['plan_description']) : "";

            // print_r($data);
            // die;

            // Begin the transaction
            $this->db->transBegin();
            try {
                // Perform the update operation
                if ($this->PlansModel->update($id, $data)) {
                    // Perform additional operations within the transaction
                    $this->PlansModel->delete_plan_services($id);
                    $this->PlansModel->insert_plan_services($id, $data['service_id']);

                    if ($data['commission_role_id']) {

                        $this->PlansModel->delete_plan_commission($id);
                        $this->PlansModel->insert_plan_commission($id, $data);
                    }
                    // Commit the transaction if all operations are successful
                    $this->db->transCommit();

                    return redirect()->to('plans')->with('msg', 'Plans updated successfully!');
                } else {
                    // Rollback the transaction if the update operation fails
                    $this->db->transRollback();

                    return redirect()->back()->with('error', 'Something went wrong!');
                }
            } catch (\Exception $e) {
                // Rollback the transaction if any exception occurs
                $this->db->transRollback();

                // Log the error
                log_message('error', 'Error updating plans: ' . $e->getMessage());

                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }

        return view('plans/edit');
    }


    public function delete($id)
    {

        $msg = 'Failed to delete record';

        $result = $this->PlansModel->delete($id);
        if ($result) {
            $msg = 'Record deleted successfully';
        }

        return redirect()->to('plans')->with('msg', $msg);
    }

    public function fetchUser()
    {
        $id = $this->request->getPost('role_id');

        $result = $this->PlansModel->fetchroleWithid($id);
        // Start building the options HTML
        $options = '<option value="">--Select--</option>';
        if ($result) {
            $options .= '<option value="' . $result->id . '">' . ucwords(str_replace('_', ' ', $result->role_name))  . '</option>';
        }
        return $options;
    }
}
