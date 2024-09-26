<?php

namespace App\Controllers;

use CodeIgniter\Controller;

use App\Models\CategoryModel;
use App\Models\OrganisationCourseModel;

class CategoryController extends BaseController
{
    public function addService()
    {
        $OrganisationCourse = new OrganisationCourseModel();

        if ($this->request->getMethod() == 'POST') {
            $session = session();
            $model = new CategoryModel();

            $rules = [
                'cat_name' => [
                    'label' => 'Service Name',
                    'rules' => [
                        'required',
                        static function ($value, $data, &$error, $field) {
                            $db = db_connect();

                            $builder = $db->table('tbl_services');

                            $builder->select('service_name');
                            $builder->where('service_name', $value);
                            $builder->where('intended_for', $data['intended_for']);
                            $result = $builder->get()->getRow();

                            if (!is_null($result)) {
                                $error = $value . ' already exist';
                                return false;
                            }

                            return true;
                        }
                    ]
                ],
                'cat_image' => [
                    'label' => 'Image',
                    'rules' => 'uploaded[cat_image]|max_size[cat_image,1024]|mime_in[cat_image,image/png,image/jpeg,image/jpg]'
                ],
                'intended_for' => [
                    'label' => 'Education category',
                    'rules' => 'required'
                ],
                'org_course_id' => [
                    'label' => 'Organization Course',
                    'rules' => 'required'
                ],
                'location_option' => [
                    'label' => 'Location',
                    'rules' => 'required'
                ],
                'search_option' => [
                    'label' => 'Search',
                    'rules' => 'required'
                ],
                'aadhar_option' => [
                    'label' => 'Aadhar Card',
                    'rules' => 'required'
                ],
                'income_option' => [
                    'label' => 'Income Certificate',
                    'rules' => 'required'
                ],
                'service_type' => [
                    'label' => 'Service Type',
                    'rules' => 'required'
                ],
                'guardian_option' => [
                    'label' => 'Guardian Details',
                    'rules' => 'required'
                ],
                'photo_option' => [
                    'label' => 'Passport Photo',
                    'rules' => 'required'
                ],
                'terms_option' => [
                    'label' => 'Terms & Conditions',
                    'rules' => 'required'
                ],
                'education_option' => [
                    'label' => 'Education Qualification',
                    'rules' => 'required'
                ]
            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();

                if (isset($errors['cat_name'])) {
                    $session->setFlashdata('name_error', $errors['cat_name']);
                }
                if (isset($errors['cat_image'])) {
                    $session->setFlashdata('image_error', $errors['cat_image']);
                }
                if (isset($errors['intended_for'])) {
                    $session->setFlashdata('intended_for_error', $errors['intended_for']);
                }
                if (isset($errors['org_course_id'])) {
                    $session->setFlashdata('course_error', $errors['org_course_id']);
                }
                if (isset($errors['location_option'])) {
                    $session->setFlashdata('location_error', $errors['location_option']);
                }
                if (isset($errors['search_option'])) {
                    $session->setFlashdata('search_error', $errors['search_option']);
                }
                if (isset($errors['aadhar_option'])) {
                    $session->setFlashdata('aadhar_error', $errors['aadhar_option']);
                }
                if (isset($errors['income_option'])) {
                    $session->setFlashdata('income_error', $errors['income_option']);
                }
                if (isset($errors['guardian_option'])) {
                    $session->setFlashdata('guardian_error', $errors['guardian_option']);
                }
                if (isset($errors['education_option'])) {
                    $session->setFlashdata('education_error', $errors['education_option']);
                }
                if (isset($errors['photo_option'])) {
                    $session->setFlashdata('photo_error', $errors['photo_option']);
                }
                if (isset($errors['terms_option'])) {
                    $session->setFlashdata('terms_error', $errors['terms_option']);
                }
                if (isset($errors['service_type'])) {
                    $session->setFlashdata('service_type_error', $errors['service_type']);
                }

                return redirect()->back()->withInput();
            }
            $test = [
                'is_location_required' => $this->request->getVar('location_option'),
                'is_search_required' => $this->request->getVar('search_option'),
                'is_aadhar_required' => $this->request->getVar('aadhar_option'),
                'is_income_required' => $this->request->getVar('income_option'),
                'is_guardian_details_required' => $this->request->getVar('guardian_option'),
                'is_education_qualification_required' => $this->request->getVar('education_option'),
                'is_passport_photo_required' => $this->request->getVar('photo_option'),
                'is_terms_and_conditions_required' => $this->request->getVar('terms_option'),
            ];
            $test = json_encode($test);
            $img = $this->request->getFile('cat_image');
            $org_course_id = $this->request->getVar('org_course_id');

            $file_upload = uploadFile($img);

            $img_name = $file_upload['file_name'];

            $data = [
                'service_name' => $this->request->getVar('cat_name'),
                'image' => $img_name,
                'intended_for' => $this->request->getVar('intended_for'),
                'required_field' => $test,
                'service_type' => $this->request->getVar('service_type'),
                'terms_and_conditions' => $this->request->getVar('terms'),
                'is_active' => $this->request->getVar('status'),
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $result_id = $model->insertData($data);

            if ($result_id) {
                $resultorg_courses = $model->insert_org_courses($result_id, $org_course_id);
                if ($resultorg_courses) {
                    $session->setFlashdata('msg', 'Service Added Successfully');
                    return redirect()->to('/category/view');
                } else {
                    $session->setFlashdata('error', 'Something Went Wrong!');
                    return redirect()->to('/category');
                }
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->to('/category');
            }
        }

        $data['course'] = $OrganisationCourse->table('tbl_organizations_course')
            ->join('tbl_organizations', 'tbl_organizations.id = tbl_organizations_course.organization_id', 'inner')
            ->join('tbl_courses', 'tbl_courses.id = tbl_organizations_course.course_id', 'inner')
            ->select('tbl_organizations_course.id, 
            tbl_organizations.name as organization_name, 
            tbl_courses.name as course_name')
            ->get()
            ->getResult();

        return view(
            'category/add',
            $data
        );
    }

    public function services()
    {
        $model = new CategoryModel();

        $data['categories'] = $model->getData();
        return view('category/view', $data);
    }

    public function editService($id)
    {
        $model = new CategoryModel();
        $OrganisationCourse = new OrganisationCourseModel();

        $data['category'] = $model->getDataById($id);
        $data['course'] = $OrganisationCourse->table('tbl_organizations_course')
            ->join('tbl_organizations', 'tbl_organizations.id = tbl_organizations_course.organization_id', 'inner')
            ->join('tbl_courses', 'tbl_courses.id = tbl_organizations_course.course_id', 'inner')
            ->select('tbl_organizations_course.id, 
            tbl_organizations.name as organization_name, 
            tbl_courses.name as course_name')
            ->get()
            ->getResult();
        $data['course_service'] = $model->_course_service($id);
        return view('category/edit', $data);
    }

    public function updateData($id)
    {
        $model = new CategoryModel();

        $session = session();

        $category = $model->getDataById($id);

        $rules = [
            'cat_name' => [
                'label' => 'Service Name',
                'rules' => [
                    'required',
                    function ($value, $data, &$error) use ($id) {
                        $db = db_connect();
                        $builder = $db->table('tbl_services');

                        // Check if the service name already exists for another ID
                        $builder->select('service_name');
                        $builder->where('id !=', $id);
                        $builder->where('service_name', $value);
                        $builder->where('intended_for', $data['intended_for']);
                        $result = $builder->get()->getRow();

                        if (!is_null($result)) {
                            $error = $value . ' already exists';
                            return false;
                        }

                        return true;
                    }
                ]
            ],

            'intended_for' => [
                'label' => 'Education category',
                'rules' => 'required'
            ],

            'org_course_id' => [
                'label' => 'Organization Course',
                'rules' => 'required'
            ],

            'location_option' => [
                'label' => 'Location',
                'rules' => 'required'
            ],
            'search_option' => [
                'label' => 'Search',
                'rules' => 'required'
            ],
            'aadhar_option' => [
                'label' => 'Aadhar Card',
                'rules' => 'required'
            ],
            'income_option' => [
                'label' => 'Income Certificate',
                'rules' => 'required'
            ],
            'service_type' => [
                'label' => 'Service Type',
                'rules' => 'required'
            ],
            'guardian_option' => [
                'label' => 'Guardian Details',
                'rules' => 'required'
            ],
            'photo_option' => [
                'label' => 'Passport Photo',
                'rules' => 'required'
            ],
            'terms_option' => [
                'label' => 'Terms & Conditions',
                'rules' => 'required'
            ],
            'education_option' => [
                'label' => 'Education Qualification',
                'rules' => 'required'
            ]
        ];

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            if (isset($errors['cat_name'])) {
                $session->setFlashdata('name_error', $errors['cat_name']);
            }

            if (isset($errors['intended_for'])) {
                $session->setFlashdata('intended_for_error', $errors['intended_for']);
            }

            if (isset($errors['org_course_id'])) {
                $session->setFlashdata('course_error', $errors['org_course_id']);
            }

            if (isset($errors['location_option'])) {
                $session->setFlashdata('location_error', $errors['location_option']);
            }
            if (isset($errors['search_option'])) {
                $session->setFlashdata('search_error', $errors['search_option']);
            }
            if (isset($errors['aadhar_option'])) {
                $session->setFlashdata('aadhar_error', $errors['aadhar_option']);
            }
            if (isset($errors['income_option'])) {
                $session->setFlashdata('income_error', $errors['income_option']);
            }
            if (isset($errors['guardian_option'])) {
                $session->setFlashdata('guardian_error', $errors['guardian_option']);
            }
            if (isset($errors['education_option'])) {
                $session->setFlashdata('education_error', $errors['education_option']);
            }
            if (isset($errors['photo_option'])) {
                $session->setFlashdata('photo_error', $errors['photo_option']);
            }
            if (isset($errors['terms_option'])) {
                $session->setFlashdata('terms_error', $errors['terms_option']);
            }
            if (isset($errors['service_type'])) {
                $session->setFlashdata('service_type_error', $errors['service_type']);
            }
            return redirect()->to('/category/edit/' . $id);
        }

        $test = [
            'is_location_required' => $this->request->getVar('location_option'),
            'is_search_required' => $this->request->getVar('search_option'),
            'is_aadhar_required' => $this->request->getVar('aadhar_option'),
            'is_income_required' => $this->request->getVar('income_option'),
            'is_guardian_details_required' => $this->request->getVar('guardian_option'),
            'is_education_qualification_required' => $this->request->getVar('education_option'),
            'is_passport_photo_required' => $this->request->getVar('photo_option'),
            'is_terms_and_conditions_required' => $this->request->getVar('terms_option'),
        ];

        $test = json_encode($test);
        $cat_name = $this->request->getVar('cat_name');
        $status = $this->request->getVar('status');
        $img = $this->request->getFile('cat_image');
        $intended_for = $this->request->getVar('intended_for');
        $org_course_id = $this->request->getVar('org_course_id');

        if (isset($img) && $img != '') {
            $uploadImg = uploadFile($img);
            $newImg = $uploadImg['file_name'];
        }

        $data = [
            'service_name' => $cat_name,
            'image' => isset($newImg) ? $newImg : $category->image,
            'service_type' => $this->request->getVar('service_type'),
            'intended_for' => $intended_for,
            'required_field' => $test,
            'terms_and_conditions' => $this->request->getVar('terms'),
            'is_active' => $status,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $result = $model->updateData($data, $id);

        if ($result) {
            $model->delete_org_courses($id);
            $resultorg_courses = $model->insert_org_courses($id, $org_course_id);
            if ($resultorg_courses) {
                $session->setFlashdata('msg', 'Service Updated Successfully');
                return redirect()->to('/category/view');
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->to('/category/edit/' . $id);
            }
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/category/edit/' . $id);
        }
    }


    public function delete($id)
    {
        $model = new CategoryModel();
        $session = session();

        $result = $model->deleteData($id);

        if ($result) {
            $session->setFlashdata('msg', 'Service deleted Successfully');
            return redirect()->to('/category/view');
        } else {
            $session->setFlashdata('error', 'Something Went Wrong!');
            return redirect()->to('/category/view');
        }
    }
}
