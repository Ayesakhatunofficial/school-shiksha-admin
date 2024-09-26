<?php

namespace App\Controllers;

use App\Models\CourseModel;

class CourseController extends BaseController
{
    public function addCourse()
    {
        if ($this->request->getVar()) {
            $session = session();
            $model = new CourseModel();

            $rules = [
                'course_name' => [
                    'label' => 'Course Name',
                    'rules' => 'required'
                ],

                'course_details' => [
                    'label' => 'Course Details',
                    'rules' => 'required'
                ],

                'course_type' => [
                    'label' => 'Course Type',
                    'rules' => 'required'
                ]

            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                if (isset($errors['course_name'])) {
                    $session->setFlashdata('name_error', $errors['course_name']);
                }

                if (isset($errors['course_details'])) {
                    $session->setFlashdata('details_error', $errors['course_details']);
                }

                if (isset($errors['course_type'])) {
                    $session->setFlashdata('type_error', $errors['course_type']);
                }

                return redirect()->to('/course');
            }

            $name = $this->request->getVar('course_name');
            $status = $this->request->getVar('status');
            $type = $this->request->getVar('course_type');
            $course_details = $this->request->getVar('course_details');

            $data = [
                'name' => $name,
                'course_details' => $course_details,
                'is_active' => $status,
                'course_type' => $type,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $result = $model->insertData($data);

            if ($result) {
                $session->setFlashdata('msg', 'Course Added Successfully');
                return redirect()->to('/course/view');
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->to('/course');
            }
        }
        return view('course/add');
    }

    public function courses()
    {
        $model = new CourseModel();

        $data['courses'] = $model->getData();
        return view('course/view', $data);
    }

    public function editCourse($id)
    {
        $model = new CourseModel();

        $data['course'] = $model->getDataById($id);

        return view('course/edit', $data);
    }

    public function updateData($id)
    {
        $model = new CourseModel();

        $session = session();

        $organization = $model->getDataById($id);

        $rules = [
            'course_name' => [
                'label' => 'Course Name',
                'rules' => 'required'
            ],

            'course_details' => [
                'label' => 'Course Details',
                'rules' => 'required'
            ],

            'course_type' => [
                'label' => 'Course Type',
                'rules' => 'required'
            ]

        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            if (isset($errors['course_name'])) {
                $session->setFlashdata('name_error', $errors['course_name']);
            }

            if (isset($errors['course_details'])) {
                $session->setFlashdata('details_error', $errors['course_details']);
            }

            if (isset($errors['course_type'])) {
                $session->setFlashdata('type_error', $errors['course_type']);
            }
            return redirect()->to('/course/edit/' . $id);
        }

        $name = $this->request->getVar('course_name');
        $status = $this->request->getVar('status');
        $type = $this->request->getVar('course_type');
        $course_details = $this->request->getVar('course_details');

        $data = [
            'name' => $name,
            'course_details' => $course_details,
            'is_active' => $status,
            'course_type' => $type,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $session->setFlashdata('msg', 'Course Updated Successfully');
            return redirect()->to('/course/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/course/edit/' . $id);
        }
    }

    public function active($id)
    {
        $model  = new CourseModel();

        $session = session();

        $data = [
            'is_active' => 1,
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $session->setFlashdata('msg', 'Status Active Successfully');
            return redirect()->to('/course/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/course/view');
        }
    }

    public function inactive($id)
    {
        $model  = new CourseModel();

        $session = session();

        $data = [
            'is_active' => 0,
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $session->setFlashdata('msg', 'Status Inactive Successfully');
            return redirect()->to('/course/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/course/view');
        }
    }

    public function  delete($id)
    {
        $model = new CourseModel();
        $session = session();

        $result = $model->deleteData($id);

        if ($result) {
            $session->setFlashdata('msg', 'Organization deleted Successfully');
            return redirect()->to('/course/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/course/view');
        }
    }
}
