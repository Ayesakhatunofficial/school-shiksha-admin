<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\StudentModel;
use App\Models\StatesModel;
use App\Models\DistrictModel;
use App\Models\PlansModel;
use App\Models\SettingModel;
use App\Models\ClassModel;
use App\Models\OrganizationModel;
use DateTime;
use CodeIgniter\HTTP\Files\UploadedFile;

class StudentController extends BaseController
{
    public function addStudent()
    {
        $StatesModel = new StatesModel();
        $model = new StudentModel();
        $ClassModel = new ClassModel();

        $session = session();
        $data['class'] = $ClassModel->findAll();
        $data['states'] = $StatesModel->findAll();

        $planModel = new PlansModel();

        $role_id = getRoleId('student');

        $data['plans'] = $planModel
            ->where('role_id', $role_id)
            ->where('is_active', 1)
            ->findAll();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'name' => [
                    'label' => 'Full Name',
                    'rules' => 'required'
                ],
                'mobile' => [
                    'label' => 'Mobile No.',
                    'rules' => [
                        'required',
                        'integer',
                        'min_length[10]',
                        'max_length[10]',
                        static function ($value, $data, &$error, $field) {
                            $db = db_connect();

                            $result = $db->query("SELECT * FROM tbl_users WHERE mobile = ?", [$value])->getRow();

                            if (!is_null($result)) {
                                $error = $value . ' already exist';
                                return false;
                            }

                            return true;
                        }
                    ]
                ],
                'guardian_mobile' => [
                    'label' => 'Guardian Mobile No.',
                    'rules' => [
                        'required',
                        'integer',
                        'min_length[10]',
                        'max_length[10]',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => [
                        'required',
                        'valid_email',
                        static function ($value, $data, &$error, $field) {
                            $db = db_connect();

                            $result = $db->query("SELECT * FROM tbl_users WHERE email = ?", [$value])->getRow();

                            if (!is_null($result) || !empty($result)) {
                                $error = $value . ' already exist';
                                return false;
                            }

                            return true;
                        }
                    ]
                ],
                'dob' => [
                    'label' => 'Date of Birth ',
                    'rules' => 'required'
                ],
                'father_name' => [
                    'label' => 'Guardian Name',
                    'rules' => 'required'
                ],
                'guardian_occupation' => [
                    'label' => 'Guardian Occupation',
                    'rules' => 'required'
                ],
                'class_id' => [
                    'label' => 'Class Name',
                    'rules' => 'required'
                ],
                'gender' => [
                    'label' => 'Gender',
                    'rules' => 'required'
                ],
                'religion' => [
                    'label' => 'Religion',
                    'rules' => 'required'
                ],

                'institute_name' => [
                    'label' => 'School/College Name',
                    'rules' => 'required'
                ],

                'stream_name' => [
                    'label' => 'Stream Name',
                    'rules' => 'required'
                ],

                'pincode' => [
                    'label' => 'Pincode',
                    'rules' => 'required'
                ],
                'police_station' => [
                    'label' => 'Police Station',
                    'rules' => 'required'
                ],
                'state_id' => [
                    'label' => 'State',
                    'rules' => 'required'
                ],
                'district_id' => [
                    'label' => 'District',
                    'rules' => [
                        'required',
                        static function ($value, $data, &$error, $field) {

                            if ($value != '') {
                                $db = db_connect();

                                $result = $db->query("SELECT * FROM tbl_districts WHERE id = ?", [$value])->getRow();

                                if (is_null($result) || empty($result)) {
                                    $error = $value . ' invalid District Id';
                                    return false;
                                }

                                return true;
                            } else {
                                return true;
                            }
                        }
                    ]
                ],
                'address' => [
                    'label' => 'Address',
                    'rules' => 'required'
                ],
                'whatsapp_number' => [
                    'label' => 'Whatsapp No.',
                    'rules' => [
                        'required',
                        'integer',
                        'min_length[10]',
                        'max_length[10]',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required'
                ],
                'plan_id' => [
                    'label' => 'Plan',
                    'rules' => 'required'
                ]

            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();
                if (isset($errors['name'])) {
                    $session->setFlashdata('name_error', $errors['name']);
                }

                if (isset($errors['email'])) {
                    $session->setFlashdata('email_error', $errors['email']);
                }

                if (isset($errors['mobile'])) {
                    $session->setFlashdata('mobile_error', $errors['mobile']);
                }

                if (isset($errors['guardian_mobile'])) {
                    $session->setFlashdata('guardian_mobile_error', $errors['guardian_mobile']);
                }

                if (isset($errors['dob'])) {
                    $session->setFlashdata('dob_error', $errors['dob']);
                }

                if (isset($errors['father_name'])) {
                    $session->setFlashdata('father_error', $errors['father_name']);
                }

                if (isset($errors['guardian_occupation'])) {
                    $session->setFlashdata('guardian_occupation_error', $errors['guardian_occupation']);
                }

                if (isset($errors['class_id'])) {
                    $session->setFlashdata('class_error', $errors['class_id']);
                }

                if (isset($errors['gender'])) {
                    $session->setFlashdata('gender_error', $errors['gender']);
                }

                if (isset($errors['nationality'])) {
                    $session->setFlashdata('nationality_error', $errors['nationality']);
                }

                if (isset($errors['religion'])) {
                    $session->setFlashdata('religion_error', $errors['religion']);
                }

                if (isset($errors['institute_name'])) {
                    $session->setFlashdata('institute_name_error', $errors['institute_name']);
                }

                if (isset($errors['stream_name'])) {
                    $session->setFlashdata('stream_name_error', $errors['stream_name']);
                }

                if (isset($errors['address'])) {
                    $session->setFlashdata('address_error', $errors['address']);
                }

                if (isset($errors['pincode'])) {
                    $session->setFlashdata('pincode_error', $errors['pincode']);
                }

                if (isset($errors['police_station'])) {
                    $session->setFlashdata('police_station_error', $errors['police_station']);
                }

                if (isset($errors['state_id'])) {
                    $session->setFlashdata('state_error', $errors['state_id']);
                }

                if (isset($errors['district_id'])) {
                    $session->setFlashdata('district_error', $errors['district_id']);
                }

                if (isset($errors['whatsapp_number'])) {
                    $session->setFlashdata('whatsapp_error', $errors['whatsapp_number']);
                }

                if (isset($errors['password'])) {
                    $session->setFlashdata('password_error', $errors['password']);
                }

                if (isset($errors['plan_id'])) {
                    $session->setFlashdata('plan_error', $errors['plan_id']);
                }

                return redirect()->back()->withInput(); // Keep the input values
            }

            $std_data = $this->request->getVar();

            $result = $model->addData($std_data);

            if ($result && is_object($result)) {
                $data['response'] = $result;

                return view('upi/qrcode', $data);
            } else if ($result) {
                $session->setFlashdata('msg', 'Student Added Successfully');
                return redirect()->to('student/view/free-students');
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->back()->withInput();
            }
        }

        return view('student/add', $data);
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

    public function viewStudents()
    {
        $model = new StudentModel();

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);
            $columnIndex = $this->request->getGet('order')[0]['column'];
            $sortColumnIndex = filter_var($columnIndex, FILTER_SANITIZE_NUMBER_INT);
            $direction = $this->request->getGet('order')[0]['dir'];
            $sortDirection = filter_var($direction, FILTER_SANITIZE_STRING);

            $refferal_filter = $this->request->getGet('columns')[1]['search']['value'];

            $column = array('name', 'email', 'mobile', 'district_name');

            $query = "SELECT 
                        s.id as id,
                        s.name as name,
                        s.email as email,
                        au.username,
                        u.id as stud_id,
                        u.mobile as mobile,
                        u.is_active as status,
                        d.name as district_name
                    FROM 
                        tbl_students s
                    JOIN tbl_users u ON u.id = s.user_id
                    LEFT JOIN tbl_users au ON au.id = s.affilate_agent_id
                    JOIN tbl_districts d ON s.district_id = d.id
                    WHERE 1 ";

            if ($refferal_filter == 1) {
                $query .= "  AND s.affilate_agent_id IS NOT NULL";
            } else if ($refferal_filter == 0) {
                $query .= "  AND s.affilate_agent_id IS NULL";
            }

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                                s.name $like
                                OR s.email $like
                                OR u.mobile $like
                                OR d.name $like
                                OR u.is_active $like
                            ) ";
            }

            if ($sortColumnIndex != '' && $sortColumnIndex != 0) {
                if ($sortColumnIndex == 4) {
                    $sortColumn = 'district_name';
                } else {
                    $sortColumn = $column[$sortColumnIndex];
                }
                $query .= " ORDER BY $sortColumn $sortDirection";
            } else {
                $query .= ' ORDER BY s.id DESC';
            }

            $totalRecords = count($model->getStudents($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getStudents($query);
            // echo '<pre>';
            // print_r($result);
            // die;

            $data = array();

            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {

                    $status = ''; // Initialize the status badge variable

                    if ($row->status == 0) {
                        $status = '<a><label class="badge badge-danger">Inactive</label></a>';
                    } else if ($row->status == 1) {
                        $status = '<a><label class="badge badge-success">Active</label></a>';
                    }

                    $buttons = '
                            <a href="' . base_url('student/single/view/' . $row->id) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        ';

                    $data[] = [
                        $i,
                        $row->name,
                        $row->email,
                        $row->mobile,
                        $row->district_name,
                        $row->username,
                        $status,
                        $buttons
                    ];

                    $i++;
                }
            }

            $output = array(
                'draw' => intval($this->request->getGet('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            );

            echo json_encode($output);
            return;
        }
        return view('student/all_students');
    }

    public function viewFreeStudent()
    {
        $model = new StudentModel();

        $user = getUserData();

        $role = getRole($user->role_id);

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);
            $columnIndex = $this->request->getGet('order')[0]['column'];
            $sortColumnIndex = filter_var($columnIndex, FILTER_SANITIZE_NUMBER_INT);
            $direction = $this->request->getGet('order')[0]['dir'];
            $sortDirection = filter_var($direction, FILTER_SANITIZE_STRING);

            $column = array('name', 'email', 'mobile', 'district_name');

            $query = "SELECT 
                        tbl_students.id as id,
                        tbl_students.name as name,
                        tbl_students.email as email,
                        tbl_users.id as stud_id,
                        tbl_users.mobile as mobile,
                        tbl_users.is_active as status,
                        tbl_districts.name as district_name
                    FROM 
                        tbl_students
                    JOIN tbl_users ON tbl_users.id = tbl_students.user_id
                    JOIN tbl_user_subscriptions  s ON s.user_id = tbl_users.id 
                    JOIN tbl_invoices i ON i.id = s.invoice_id 
                    JOIN tbl_districts ON tbl_students.district_id = tbl_districts.id
                    WHERE 1  AND s.subscription_status = 'active' AND  i.total = 0";

            if ($role == ROLE_AFFILATE_AGENT) {
                $query .= " AND tbl_users.created_by = $user->id";
            }

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                                tbl_students.name $like
                                OR tbl_students.email $like
                                OR tbl_users.mobile $like
                                OR tbl_districts.name $like
                                OR tbl_users.is_active $like
                            ) ";
            }

            if ($sortColumnIndex != '' && $sortColumnIndex != 0) {
                if ($sortColumnIndex == 4) {
                    $sortColumn = 'district_name';
                } else {
                    $sortColumn = $column[$sortColumnIndex];
                }
                $query .= " ORDER BY $sortColumn $sortDirection";
            } else {
                $query .= ' ORDER BY tbl_students.id DESC';
            }

            $totalRecords = count($model->getStudents($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getStudents($query);
            // print_r($result);
            // die;

            $data = array();

            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {

                    $status = ''; // Initialize the status badge variable

                    if ($row->status == 0) {
                        $status = '<a><label class="badge badge-danger">Inactive</label></a>';
                    } else if ($row->status == 1) {
                        $status = '<a><label class="badge badge-success">Active</label></a>';
                    }

                    $buttons = '
                            <a href="' . base_url('student/single/view/' . $row->id) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                <i class="mdi mdi-eye"></i>
                            </a>
                            <a href="' . base_url('student/edit/' . $row->id) . '" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" title="Edit">
                                    <i class="mdi mdi-pencil"></i>
                            </a>
                             <a href="' . base_url('student/' . $row->stud_id . '/invoice') . '" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" title="Invoice">
                             <i class="mdi mdi-file"></i>
                             </a>
                             <a href="' . base_url('student/' . $row->id . '/idCard') . '" class="btn a-btn btn-inverse-warning btn-rounded btn-icon" title="Student ID Card">
                             <i class="fas fa-id-card"></i>
                             </a>
                        ';





                    $data[] = [
                        $i,
                        $row->name,
                        $row->email,
                        $row->mobile,
                        $row->district_name,
                        $status,
                        $buttons
                    ];

                    $i++;
                }
            }

            $output = array(
                'draw' => intval($this->request->getGet('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            );

            echo json_encode($output);
            return;
        }


        return view('student/view');
    }

    public function viewPaidStudent()
    {
        $model = new StudentModel();

        $user = getUserData();

        $role = getRole($user->role_id);

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);
            $columnIndex = $this->request->getGet('order')[0]['column'];
            $sortColumnIndex = filter_var($columnIndex, FILTER_SANITIZE_NUMBER_INT);
            $direction = $this->request->getGet('order')[0]['dir'];
            $sortDirection = filter_var($direction, FILTER_SANITIZE_STRING);

            $column = array('name', 'email', 'mobile', 'district_name');

            $query = "SELECT 
                        tbl_students.id as id,
                        tbl_students.name as name,
                        tbl_students.email as email,
                        tbl_users.id as stud_id,
                        tbl_users.mobile as mobile,
                        tbl_users.is_active as status,
                        tbl_districts.name as district_name
                    FROM 
                        tbl_students
                    JOIN tbl_users ON tbl_users.id = tbl_students.user_id
                    JOIN tbl_user_subscriptions  s ON s.user_id = tbl_users.id
                    JOIN tbl_invoices i ON i.id = s.invoice_id 
                    JOIN tbl_districts ON tbl_students.district_id = tbl_districts.id
                    WHERE 1 AND s.subscription_status = 'active' AND i.total > 0  ";

            if ($role == ROLE_AFFILATE_AGENT) {
                $query .= " AND tbl_users.created_by = $user->id";
            }

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                                tbl_students.name $like
                                OR tbl_students.email $like
                                OR tbl_users.mobile $like
                                OR tbl_districts.name $like
                                OR tbl_users.is_active $like
                            ) ";
            }

            if ($sortColumnIndex != '' && $sortColumnIndex != 0) {
                if ($sortColumnIndex == 4) {
                    $sortColumn = 'district_name';
                } else {
                    $sortColumn = $column[$sortColumnIndex];
                }
                $query .= " ORDER BY $sortColumn $sortDirection";
            } else {
                $query .= ' ORDER BY tbl_students.id DESC';
            }

            $totalRecords = count($model->getStudents($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getStudents($query);
            // print_r($result);
            // die;

            $data = array();

            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {

                    $status = ''; // Initialize the status badge variable

                    if ($row->status == 0) {
                        $status = '<a><label class="badge badge-danger">Inactive</label></a>';
                    } else if ($row->status == 1) {
                        $status = '<a><label class="badge badge-success">Active</label></a>';
                    }

                    $buttons = '
                            <a href="' . base_url('student/single/view/' . $row->id) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                <i class="mdi mdi-eye"></i>
                            </a>
                            <a href="' . base_url('student/edit/' . $row->id) . '" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" title="Edit">
                            <i class="mdi mdi-pencil"></i>
                            </a>
                            <a href="' . base_url('student/' . $row->stud_id . '/invoice') . '" class="btn a-btn btn-inverse-primary btn-rounded btn-icon" title="Invoice">
                            <i class="mdi mdi-file"></i>
                            </a>

                            <a href="' . base_url('student/' . $row->id . '/idCard') . '" class="btn a-btn btn-inverse-warning btn-rounded btn-icon" title="Student ID Card">
                             <i class="fas fa-id-card"></i>
                             </a>
                        ';



                    // <a href="' . base_url('student/delete/' . $row->id) . '" class="btn a-btn btn-inverse-danger btn-rounded btn-icon">
                    //     <i class="mdi mdi-delete"></i>
                    // </a>

                    $data[] = [
                        $i,
                        $row->name,
                        $row->email,
                        $row->mobile,
                        $row->district_name,
                        $status,
                        $buttons
                    ];

                    $i++;
                }
            }

            $output = array(
                'draw' => intval($this->request->getGet('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            );

            echo json_encode($output);
            return;
        }


        return view('student/paid_students');
    }

    public function viewSingleData($id)
    {
        $model = new StudentModel();

        $data['student'] = $model->getSingleData($id);

        $user_id = $data['student']->user_id;

        $data['plan'] = $model->getPlan($user_id);
        return view('student/signle', $data);
    }

    public function editData($id)
    {
        $disModel = new DistrictModel();
        $model = new StudentModel();
        $ClassModel = new ClassModel();
        $StatesModel = new StatesModel();
        $session = session();

        $data['class'] = $ClassModel->findAll();
        $data['student'] = $model->getSingleData($id);
        $data['states'] = $StatesModel->findAll();
        $data['state'] = $disModel->find($data['student']->district_id);
        $data['districts'] = $disModel->where('is_active', 1)->where('state_id', $data['state']['state_id'])->findAll();

        if ($this->request->getMethod() == 'POST') {

            $user_id = $data['student']->user_id;

            $user_plan = getUserById($user_id);

            $rules = [
                'name' => [
                    'label' => 'Full Name',
                    'rules' => 'required'
                ],

                'guardian_mobile' => [
                    'label' => 'Guardian Mobile No.',
                    'rules' => [
                        'required',
                        'integer',
                        'min_length[10]',
                        'max_length[10]',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => [
                        'required',
                        'valid_email',
                        "is_unique[tbl_users.email,id,{$user_id}]"
                    ]
                ],

                'dob' => [
                    'label' => 'Date of Birth ',
                    'rules' => 'required'
                ],
                'father_name' => [
                    'label' => 'Guardian Name',
                    'rules' => 'required'
                ],
                'guardian_occupation' => [
                    'label' => 'Guardian Occupation',
                    'rules' => 'required'
                ],
                'class_id' => [
                    'label' => 'Class Name',
                    'rules' => 'required'
                ],
                'gender' => [
                    'label' => 'Gender',
                    'rules' => 'required'
                ],
                'religion' => [
                    'label' => 'Religion',
                    'rules' => 'required'
                ],

                'institute_name' => [
                    'label' => 'School/College Name',
                    'rules' => 'required'
                ],

                'stream_name' => [
                    'label' => 'Stream Name',
                    'rules' => 'required'
                ],

                'pincode' => [
                    'label' => 'Pincode',
                    'rules' => 'required'
                ],
                'police_station' => [
                    'label' => 'Police Station',
                    'rules' => 'required'
                ],
                'state_id' => [
                    'label' => 'State',
                    'rules' => 'required'
                ],
                'district_id' => [
                    'label' => 'District',
                    'rules' => [
                        'required',
                        static function ($value, $data, &$error, $field) {

                            if ($value != '') {
                                $db = db_connect();

                                $result = $db->query("SELECT * FROM tbl_districts WHERE id = ?", [$value])->getRow();

                                if (is_null($result) || empty($result)) {
                                    $error = $value . ' invalid District Id';
                                    return false;
                                }

                                return true;
                            } else {
                                return true;
                            }
                        }
                    ]
                ],
                'address' => [
                    'label' => 'Address',
                    'rules' => 'required'
                ],
                'whatsapp_number' => [
                    'label' => 'Whatsapp No.',
                    'rules' => [
                        'required',
                        'integer',
                        'min_length[10]',
                        'max_length[10]',
                    ]
                ]

            ];

            if (!$this->validate($rules)) {
                $errors = $this->validator->getErrors();

                if (isset($errors['name'])) {
                    $session->setFlashdata('name_error', $errors['name']);
                }

                if (isset($errors['email'])) {
                    $session->setFlashdata('email_error', $errors['email']);
                }

                if (isset($errors['mobile'])) {
                    $session->setFlashdata('mobile_error', $errors['mobile']);
                }

                if (isset($errors['guardian_mobile'])) {
                    $session->setFlashdata('guardian_mobile_error', $errors['guardian_mobile']);
                }

                if (isset($errors['dob'])) {
                    $session->setFlashdata('dob_error', $errors['dob']);
                }

                if (isset($errors['father_name'])) {
                    $session->setFlashdata('father_error', $errors['father_name']);
                }

                if (isset($errors['guardian_occupation'])) {
                    $session->setFlashdata('guardian_occupation_error', $errors['guardian_occupation']);
                }

                if (isset($errors['class_id'])) {
                    $session->setFlashdata('class_error', $errors['class_id']);
                }

                if (isset($errors['gender'])) {
                    $session->setFlashdata('gender_error', $errors['gender']);
                }

                if (isset($errors['nationality'])) {
                    $session->setFlashdata('nationality_error', $errors['nationality']);
                }

                if (isset($errors['religion'])) {
                    $session->setFlashdata('religion_error', $errors['religion']);
                }

                if (isset($errors['institute_name'])) {
                    $session->setFlashdata('institute_name_error', $errors['institute_name']);
                }

                if (isset($errors['stream_name'])) {
                    $session->setFlashdata('stream_name_error', $errors['stream_name']);
                }

                if (isset($errors['address'])) {
                    $session->setFlashdata('address_error', $errors['address']);
                }

                if (isset($errors['pincode'])) {
                    $session->setFlashdata('pincode_error', $errors['pincode']);
                }

                if (isset($errors['police_station'])) {
                    $session->setFlashdata('police_station_error', $errors['police_station']);
                }

                if (isset($errors['state_id'])) {
                    $session->setFlashdata('state_error', $errors['state_id']);
                }

                if (isset($errors['district_id'])) {
                    $session->setFlashdata('district_error', $errors['district_id']);
                }

                if (isset($errors['whatsapp_number'])) {
                    $session->setFlashdata('whatsapp_error', $errors['whatsapp_number']);
                }

                if (isset($errors['password'])) {
                    $session->setFlashdata('password_error', $errors['password']);
                }

                if (isset($errors['plan_id'])) {
                    $session->setFlashdata('plan_error', $errors['plan_id']);
                }

                return redirect()->back()->withInput(); // Keep the input values
            }

            $std_data = $this->request->getVar();

            $result = $model->updateData($std_data, $id);

            if ($result) {
                if (!is_null($user_plan) && $user_plan->current_plan->plan_type == 'free_plan') {
                    $session->setFlashdata('msg', 'Student Updated Successfully');
                    return redirect()->to('student/view/free-students');
                } else {
                    $session->setFlashdata('msg', 'Student Updated Successfully');
                    return redirect()->to('student/view/paid-students');
                }
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->to('student/edit/' . $id);
            }
        }

        return view('student/edit', $data);
    }

    public function txnStatus()
    {
        $arr = [
            'status' => 'PENDING',
            'message' => 'payment pending'
        ];

        $order_id = $this->request->getVar('order_id');

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => getenv('PAYMENT_BASE_URL') . 'check_order_status',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('client_orderid' => $order_id),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);


        $response = json_decode($response);

        if ($response->data->status == 'TXN_SUCCESS') {

            $post_data = session()->get('post_data');

            $model = new StudentModel();

            if (isset($post_data)) {

                $result = $model->addStudentData($post_data);

                if ($result) {

                    session()->remove('post_data');

                    $arr = [
                        'status' => 'SUCCESS',
                        'message' => 'payment done'
                    ];
                }
            }
        }


        echo json_encode($arr);
    }

    public function renewPlan($id)
    {
        $pament_status = $this->request->getVar('payment_status');

        if (!is_null($pament_status) && $pament_status != '') {
            if ($pament_status == 'success') {
                session()->setFlashdata('msg', 'Payment successfully. Plan Activated');
            } else {
                session()->setFlashdata('error', 'Payment unsuccessful. Please try again');
            }
        }

        $data['stud_id'] = $id;

        $role_id = getRoleId('student');

        $planModel = new PlansModel();
        $model = new StudentModel();

        $data['plans'] = $planModel->where('role_id', $role_id)
            ->where('is_active', 1)
            ->orderBy('plan_amount', 'ASC')
            ->findAll();

        $data['current_plan'] = $model->getPlan($id);

        return view('plans/buy', $data);
    }

    public function payment()
    {
        $plan_id = $this->request->getVar('id');
        $stud_id = $this->request->getVar('stud_id');

        $model = new PlansModel();

        $plan_details = $model->where('id', $plan_id)->find();

        $amount = $plan_details[0]['plan_amount'];
        // $amount = 1;
        $txn_note = 'UPI Payment';

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => getenv('PAYMENT_BASE_URL') . 'create_order',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('token' => getenv('PAYMENT_TOKEN'), 'secret' => getenv('PAYMENT_SECRET'), 'amount' => $amount, 'txn_note' => $txn_note, 'udf1' => '', 'udf2' => ''),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        echo $response;
    }

    public function statusCheck()
    {
        $order_id = $this->request->getVar('orderId');
        $stud_id = $this->request->getVar('stud_id');
        $plan_id = $this->request->getVar('plan_id');

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => getenv('PAYMENT_BASE_URL') . 'check_order_status',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('client_orderid' => $order_id),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        $arr = [
            'status' => 'PENDING',
            'message' => 'payment pending'
        ];

        if ($response->data->status == 'TXN_SUCCESS') {

            $studentModel = new StudentModel();

            $result = $studentModel->addSubscription($plan_id, $stud_id);

            if ($result) {

                $arr = [
                    'status' => 'SUCCESS',
                    'message' => 'payment done'
                ];
            }
        }

        echo json_encode($arr);
    }

    public function invoice($id)
    {
        $model = new StudentModel();
        $data['user_id'] = $id;
        $data['invoices'] = $model->getInvoiceList($id);
        return view('invoice/invoice', $data);
    }

    public function invoiceView($user_id, $inv_id)
    {
        $model = new StudentModel();
        $settingModel = new SettingModel();
        $data['setting'] = $settingModel->settingData();
        $data['invoice'] = $model->getInvoiceById($inv_id);

        return view('invoice/view', $data);
    }

    public function enquiry()
    {
        $model = new StudentModel();

        $data['services'] = $model->getServices();

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);

            $service_filter = $this->request->getGet('columns')[1]['search']['value'];

            $query = "SELECT 
                        s.service_name,
                        o.name as org_name,
                        c.name as course_name,
                        u.name,
                        u.email,
                        u.mobile,
                        e.*
                    FROM 
                        tbl_enquires e
                    INNER JOIN tbl_services s ON s.id = e.service_id
                    INNER JOIN tbl_users u ON u.id = e.created_by
                    INNER JOIN tbl_organizations_course oc ON oc.id = e.organization_course_id
                    INNER JOIN tbl_organizations o ON o.id = oc.organization_id
                    INNER JOIN tbl_courses c ON c.id = oc.course_id
                    WHERE 1 ";

            if ($service_filter != NULL && $service_filter != '') {
                $query .= "  AND e.service_id = $service_filter ";
            }

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                    u.name $like
                    OR u.email $like
                    OR u.mobile $like
                    OR s.service_name $like
                    OR e.status $like
                    OR c.name $like
                    OR o.name $like
                ) ";
            }

            $query .= ' ORDER BY e.id DESC';


            $totalRecords = count($model->getEnquiry($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getEnquiry($query);
            $data = array();
            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {
                    $date = new DateTime($row->created_at);
                    $formattedDate = $date->format('d-m-Y');

                    $status = '';
                    if ($row->status == 'rejected') {
                        $status = '<a><label class="badge badge-danger">Rejected</label></a>';
                    } else if ($row->status == 'completed') {
                        $status = '<a><label class="badge badge-success">Completed</label></a>';
                    } else if ($row->status == 'pending') {
                        $status = '<a><label class="badge badge-warning">Pending</label></a>';
                    }

                    $buttons = '
                            <a href="' . base_url('student/enquiry/view/' . $row->id) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        ';

                    $data[] = [
                        $i,
                        'Name : ' . $row->name . '<br><br> Email : ' . $row->email . '<br><br> Mobile : ' . $row->mobile,
                        'Service Name : ' . $row->service_name . '<br><br> Course Name : ' . $row->course_name . '<br><br> Organization Name : ' . $row->org_name,
                        $row->service_commission_amount,
                        $formattedDate,
                        $status,
                        $buttons
                    ];

                    $i++;
                }
            }

            $output = array(
                'draw' => intval($this->request->getGet('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            );

            echo json_encode($output);
            return;
        }
        return view('student/enquiry', $data);
    }

    public function enquiryView($id)
    {
        $session = session();
        $model = new StudentModel();
        $enquiry = $model->getEnquiryById($id);

        $data['details'] = json_decode($enquiry->enquiry_details, true);

        $data['documents'] = json_decode($enquiry->documents);

        $data['enquiry'] = $enquiry;


        if ($this->request->getMethod() == 'POST') {
            $input = [
                'status' => $this->request->getVar('status'),
            ];

            if ($this->request->getVar('remarks')) {
                $input['cancel_reason'] = $this->request->getVar('remarks');
            }

            $result = $model->changeStatus($input, $id);
            if ($result) {
                $session->setFlashdata('msg', 'Status Changed Successfully');
                return redirect()->to('student/enquiry');
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->back();
            }
        }

        return view('student/enquiry_view', $data);
    }
    public function idCard($id)
    {
        $model = new StudentModel();
        $student = $model->studentIdData($id);

        if ($student['id_card_front'] == NULL && $student['id_card_back'] == NULL && $student['id_card_data'] == NULL) {

            $result = idCardGenerate($student);

            if ($result) {
                return redirect()->to('student/' . $id . '/idCard');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        } else {
            if ($student['id_card_data'] != NULL && $student['id_card_data'] != '') {
                $id_card = json_decode($student['id_card_data']);

                if ($id_card->plan_id != $student['plan_id']) {

                    $result = idCardGenerate($student);

                    if ($result) {
                        return redirect()->to('student/' . $id . '/idCard');
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong !');
                    }
                }
            }
        }

        return view('student/studentID', ['student_id_card' => $student]);
    }
}
