<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\PlansModel;
use App\Models\SettingModel;
use Config\Session;
use DateTime;

class UserController extends BaseController
{
    protected $UserModel;
    protected $PlansModel;

    public function __construct()
    {
        $this->UserModel = new UserModel();
        $this->PlansModel = new PlansModel();
    }
    public function user($id = NULL)
    {
        $data['users'] = $this->UserModel->getUsersData($id);

        return view(
            'users/view',
            $data
        );
    }

    public function editUser($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            return redirect()->back()->with('error', 'Invalid plans ID.');
        }

        $commison = $this->UserModel->find($id);

        if (!$commison) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $roles = $this->UserModel->fetchRoles();
        return view('users/edit', [
            'users' => $commison,
            'roles' => $roles,
        ]);
    }

    public function addUser()
    {
        if ($this->request->getMethod() === 'POST') {
            $user = getUserData();
            $data = $this->request->getPost();
            $data['raw_password'] = isset($data['password']) ? $data['password'] : "";
            $data['password'] = isset($data['password']) ? md5($data['password']) : "";

            $data['created_by'] = $user->id;

            $role_name = getRole($data['role_id']);
            $username = getNextStudentId($role_name);
            $data['username'] = $username;

            $response = $this->UserModel
                ->where('email', $data['email'])
                ->orWhere('mobile', $data['mobile'])
                ->countAllResults();

            if ($response > 0) {
                return redirect()->back()->with('error', 'A user with the provided email or mobile number already exists.');
            }

            $result = $this->UserModel->addUser($data);

            if ($result && is_object($result)) {
                $data['response'] = $result;

                return view('upi/user_qrcode', $data);
            } else if ($result) {

                return redirect()->to(site_url('users/' . $data['role_id']))->with('msg', 'User inserted successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
        $data = [];
        $data['roles'] = $this->UserModel->fetchRoles();

        return view('users/add', $data);
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

            $model = new UserModel();

            if (isset($post_data)) {

                $result = $model->addUserData($post_data);

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

    public function update()
    {
        if ($this->request->getMethod() === 'POST') {
            $id = $this->request->getPost('hidden_id');
            $data = $this->request->getPost();
            if ($this->UserModel->update($id, $data)) {
                return redirect()->to(site_url('users/' . $data['role_id']))->with('msg', 'User updated successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong !');
            }
        }
        return view('users/edit');
    }


    public function delete($id)
    {
        $msg = 'Failed to delete record';
        $result = $this->UserModel->delete($id);
        if ($result) {
            $msg = 'Record deleted successfully';
        }
        return redirect()->back()->with('msg', $msg);
    }

    public function fetchPlan()
    {
        $id = $this->request->getPost('role_id');

        $result = $this->PlansModel->where('role_id', $id)->get()->getResultArray();
        // Start building the options HTML
        $options = '';
        $options = '<option value="">--Select--</option>';
        if ($result) {
            foreach ($result as $row) {
                // Concatenate each option to the $options string
                $options .= '<option value="' . $row['id'] . '">' . $row['plan_name'] . '</option>';
            }
            return $options;
        } else {
            return $options;
        }
    }

    public function activePlan($id)
    {
        $model = new UserModel();
        $data['user_id'] = $id;

        $data['plan'] = $model->getPlan($id);

        return view('users/plan', $data);
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

        $planModel = new PlansModel();
        $model = new UserModel();

        $data['user_id'] = $id;

        $user = $model->getUser($id);

        $role_id = $user['role_id'];

        $data['plans'] = $planModel->where('role_id', $role_id)
            ->where('is_active', 1)
            ->orderBy('plan_amount', 'ASC')
            ->findAll();

        $data['current_plan'] = $model->getPlan($id);

        return view('users/plan_buy', $data);
    }

    public function payment()
    {
        $plan_id = $this->request->getVar('id');
        $user_id = $this->request->getVar('user_id');

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
        $user_id = $this->request->getVar('user_id');
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

            $userModel = new UserModel();

            $result = $userModel->addSubscription($plan_id, $user_id);

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
        $model = new UserModel();
        $data['user_id'] = $id;
        $data['invoices'] = $model->getInvoiceList($id);
        return view('invoice/user_invoice', $data);
    }

    public function walletHistory($id)
    {
        $model = new UserModel();
        $data['id'] = $id;

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);

            $query = "SELECT 
                        u.name,
                        u.mobile,
                        u.email,
                        r.role_name,
                        w.* 
                    FROM 
                        tbl_wallet_txn_history w
                    LEFT JOIN tbl_users u ON u.id = w.commission_from
                    LEFT JOIN tbl_roles r ON u.role_id = r.id
                    WHERE 
                        w.user_id = $id ";

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                    u.name $like
                    OR u.email $like
                    OR u.mobile $like
                    OR r.role_name $like
                    OR w.amount $like
                    OR w.txn_type $like
                    OR w.txn_comment $like
                    OR w.ref_number $like
                    OR w.txn_date $like
                ) ";
            }

            $query .= ' ORDER BY w.id DESC';


            $totalRecords = count($model->getWalletList($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getWalletList($query);
            $data = array();
            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {
                    $date = new DateTime($row->txn_date);
                    $formattedDate = $date->format('d-m-Y');

                    if ($row->commission_from != NULL || $row->commission_from != '') {
                        $commission_from = 'Name : ' . $row->name . '<br><br> Role Name : ' . ucwords(str_replace('_', ' ', $row->role_name)) . '<br><br> Mobile : ' . $row->mobile . '<br><br> Email : ' . $row->email;
                    } else {
                        $commission_from = '';
                    }

                    $data[] = [
                        $i,
                        $formattedDate,
                        $row->ref_number,
                        $row->amount,
                        ucwords($row->txn_type),
                        $commission_from,
                        $row->txn_comment,
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

        return view('users/wallet_tran', $data);
    }

    public function invoiceView($user_id, $inv_id)
    {
        $model = new UserModel();
        $settingModel = new SettingModel();
        $data['setting'] = $settingModel->settingData();
        $data['invoice'] = $model->getInvoiceById($inv_id);

        return view('invoice/view', $data);
    }

    public function userView($id)
    {
        $model = new UserModel();

        $data['user'] = getUserById($id);
        $data['distributor'] = $model->getDistributor($id);

        $data['created_by'] = getUserById($data['user']->created_by);

        $distributors_id = $model->getSubordinateUsers($id);
        $user_id[] = $id;

        if (!empty($distributors_id)) {
            $all_id = array_merge($distributors_id, $user_id);
        } else {
            $all_id = $user_id;
        }
        $merge = '(' . implode(', ', $all_id) . ')';

        $data['agent'] = $model->getAgent($merge);

        $data['student'] = $model->getStudent($merge);

        return view('users/single', $data);
    }

    public function withdrawRequest($id)
    {
        $session = session();
        $model = new UserModel();

        $data['withdrawals'] = $model->getWithdrawals($id);

        if ($this->request->getMethod() == 'POST') {
            $data = $this->request->getVar();

            $user = getUserById($id);

            if ($user->wallet > MIN_AMOUNT) {

                $result = $model->addWithdrawRequest($data, $id);

                if ($result) {
                    $session->setFlashdata('msg', 'Withdraw request send successfully');
                    return redirect()->to('user/' . $id . '/withdraw-request');
                } else {
                    $session->setFlashdata('error', 'Something Went Wrong!');
                    return redirect()->back();
                }
            } else {
                $session->setFlashdata('error', 'Wallet Balance should greater than 1000');
                return redirect()->back();
            }
        }
        return view('withdraw/add', $data);
    }

    public function withdrawRequestList()
    {
        $model = new UserModel();

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);

            $query = "SELECT 
                        u.name,
                        u.email,
                        u.mobile,
                        w.*
                    FROM 
                        tbl_withdrawals w
                    JOIN tbl_users u ON u.id = w.request_by
                    WHERE 1 ";

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                    u.name $like
                    OR u.email $like
                    OR u.mobile $like
                    OR w.amount $like
                    OR w.request_date $like
                    OR w.remarks $like
                    OR e.status $like
                ) ";
            }

            $query .= ' ORDER BY id DESC';


            $totalRecords = count($model->getWithdraw($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getWithdraw($query);
            $data = array();
            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {
                    $date = new DateTime($row->request_date);
                    $formattedDate = $date->format('d-m-Y');

                    $status = '';
                    if ($row->status == 'rejected') {
                        $status = '<a><label class="badge badge-danger">Rejected</label></a>';
                    } else if ($row->status == 'approved') {
                        $status = '<a><label class="badge badge-success">Approved</label></a>';
                    } else if ($row->status == 'pending') {
                        $status = '<a><label class="badge badge-warning">Pending</label></a>';
                    }

                    $buttons = '
                            <a href="' . base_url('withdraw-request/view/' . $row->id) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        ';

                    $data[] = [
                        $i,
                        'Name : ' . $row->name . '<br><br> Email : ' . $row->email . '<br><br> Mobile : ' . $row->mobile,
                        $formattedDate,
                        $row->amount,
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
        return view('withdraw/view');
    }

    public function withdrawRequestView($id)
    {
        $user = getUserData();
        $session = session();
        $model = new UserModel();

        $data['withdraw'] = $model->getWithdrawById($id);

        if ($this->request->getMethod() == 'POST') {
            $input = [
                'status' => $this->request->getVar('status'),
                'approved_by' => $user->id
            ];

            if ($this->request->getVar('remarks')) {
                $input['remarks'] = $this->request->getVar('remarks');
            }

            $result = $model->changeStatus($input, $id, $data['withdraw']->amount, $data['withdraw']->request_by);

            if ($result) {
                $session->setFlashdata('msg', 'Request status changed Successfully');
                return redirect()->to('withdraw-request');
            } else {
                $session->setFlashdata('error', 'Something Went Wrong!');
                return redirect()->back();
            }
        }

        return view('withdraw/single', $data);
    }

    public function bankDetails()
    {
        $user = getUserData();
        $model = new UserModel();
        $data['bank'] = $model->getBankDetails($user->id);

        if ($this->request->getMethod() == 'POST') {
            $bank = $this->request->getVar();
            $bank_photo = $this->request->getFile('passbook');
            if (isset($bank_photo) && $bank_photo != '') {
                $uploadPhoto = uploadFile($bank_photo);
                $img = $uploadPhoto['file_name'];
            } else {
                $img = isset($data['bank']->passbook_photo) ? $data['bank']->passbook_photo : NULL;
            }

            $result = $model->addBankDetails($user->id, $bank, $img);

            if ($result) {
                return redirect()->to('user/bank_details')->with('msg', 'Bank details added successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong!');
            }
        }
        return view('bank/edit', $data);
    }

    public function viewBankDetails($id)
    {
        $model = new UserModel();
        $data['bank'] = $model->getBankDetails($id);
        return view('bank/view', $data);
    }

    public function commissions()
    {
        $model = new UserModel();
        $user = getUserData();
        $data['commissions'] = $model->getUserCommissions($user->role_id);

        return view('users/commission', $data);
    }
}
