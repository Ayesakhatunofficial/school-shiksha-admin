<?php

namespace App\Controllers;

use App\Models\BlocksModel;
use App\Models\DistrictModel;
use App\Models\OrganizationModel;
use App\Models\StatesModel;
use App\Models\OrganisationCourseModel;

class OrganizationController extends BaseController
{
    public function addOrganization()
    {
        $States = new StatesModel();

        if ($this->request->getMethod() == 'POST') {
            $session = session();
            $model = new OrganizationModel();
            $img = $this->request->getFile('org_image');
            $newImg =  uploadFile($img);

            $data = [
                'name' => $this->request->getVar('org_name'),
                'logo' => $newImg['file_name'],
                'is_active' => $this->request->getVar('status'),
                'type' => $this->request->getVar('type'),
                'mobile' => $this->request->getVar('mobile'),
                'whatsapp_number' => $this->request->getVar('whatsapp_number'),
                'state_id' =>  $this->request->getVar('state_id'),
                'district_id' => $this->request->getVar('district_id'),
                'block_id' =>  $this->request->getVar('block_id'),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $result = $model->insertData($data);

            if ($result) {
                $session->setFlashdata('msg', 'Organization Added Successfully');
                return redirect()->to('/organization/view');
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->to('/organization');
            }
        }

        $data['states'] = $States->findall();
        return view('organization/add', $data);
    }

    public function organization()
    {
        $model = new OrganizationModel();

        $data['organizations'] = $model->getData();
        return view('organization/view', $data);
    }

    public function editOrganization($id)
    {
        $model = new OrganizationModel();
        $States = new StatesModel();
        $districtModel = new DistrictModel();
        $blockModel = new BlocksModel();

        $data['states'] = $States->findall();

        $data['organization'] = $model->getDataById($id);

        $data['districts'] = $districtModel->where('state_id', $data['organization']->states_id)
            ->where('is_active', 1)->findAll();

        $data['blocks'] = $blockModel->where('district_id', $data['organization']->district_id)
            ->where('is_active', 1)->findAll();

        return view('organization/edit', $data);
    }

    public function updateData($id)
    {
        $model = new OrganizationModel();

        $session = session();

        $organization = $model->getDataById($id);


        $img = $this->request->getFile('org_image');

        if (isset($img)) {
            $newImg = uploadFile($img);
        }

        $data = [
            'name' => $this->request->getVar('org_name'),
            'logo' => isset($newImg['file_name'])  ? $newImg['file_name'] : $organization->logo,
            'type' => $this->request->getVar('type'),
            'mobile' => $this->request->getVar('mobile'),
            'whatsapp_number' => $this->request->getVar('whatsapp_number'),
            'is_active' =>  $this->request->getVar('status'),
            'state_id' => $this->request->getVar('state_id'),
            'district_id' =>  $this->request->getVar('district_id'),
            'block_id' => $this->request->getVar('block_id'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $session->setFlashdata('msg', 'Organization Updated Successfully');
            return redirect()->to('/organization/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/organization/edit/' . $id);
        }
    }

    public function active($id)
    {
        $model = new OrganizationModel();

        $session = session();

        $data = [
            'is_active' => 1,
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $session->setFlashdata('msg', 'Status Active Successfully');
            return redirect()->to('/organization/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/organization/view');
        }
    }

    public function inactive($id)
    {
        $model = new OrganizationModel();

        $session = session();

        $data = [
            'is_active' => 0,
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $session->setFlashdata('msg', 'Status Inactive Successfully');
            return redirect()->to('/organization/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/organization/view');
        }
    }

    public function delete($id)
    {
        $OrganisationCourse = new OrganisationCourseModel();

        $count = $OrganisationCourse->where('organization_id', $id)->countAllResults();

        if ($count > 0) {
            return redirect()->back()->with('error', 'You Can not delete the organization ! Because the course has been created on behalf of this organization.');
        }

        $model = new OrganizationModel();
        $session = session();

        $result = $model->deleteData($id);

        if ($result) {
            $session->setFlashdata('msg', 'Organization deleted Successfully');
            return redirect()->to('/organization/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/organization/view');
        }
    }
    public function fetchDistrict($id)
    {
        $model = new OrganizationModel();
        // Fetch districts based on the provided $id (assuming $id is used for fetching specific data)
        $result = $model->fetchDistricts($id);
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

    public function fetchBlocks($id)
    {
        $model = new OrganizationModel();
        // Fetch districts based on the provided $id (assuming $id is used for fetching specific data)
        $result = $model->fetchBlocks($id);
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
