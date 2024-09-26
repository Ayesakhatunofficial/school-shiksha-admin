<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\I18n\Time;
use DateTime;

class StudentModel extends Model
{
    protected $table = 'tbl_students';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_card_front', 'id_card_back', 'id_card_data'];
    /**
     * Add Student data with plan 
     * 
     * @param array $post_data
     * @return bool|array[object]
     */
    public function addData($post_data)
    {
        $session = session();

        $session_data = [
            'post_data' => $post_data
        ];

        $session->set($session_data);

        $role = $this->db->query("SELECT * FROM tbl_roles WHERE role_name = 'student'")->getRow();

        $username = getNextStudentId('student');

        $user = getUserData();

        $userRole = getRole($user->role_id);

        if ($userRole == ROLE_AFFILATE_AGENT) {
            $agent_id = $user->id;
        }

        try {

            $plan_id = $post_data['plan_id'];

            $plan_details = $this->db->table('tbl_plans')
                ->where('id', $plan_id)
                ->get()
                ->getRow();

            if ($plan_details->plan_amount == 0) {

                $this->db->transException(true)->transStart();

                $user_data = [
                    'username' => $username,
                    'role_id' => $role->id,
                    'name' => $post_data['name'],
                    'email' => $post_data['email'],
                    'mobile' => $post_data['mobile'],
                    'password' => md5($post_data['password']),
                    'is_active' => 1,
                    'created_by' => $user->id
                ];

                $this->db->table('tbl_users')->insert($user_data);
                $std_insert_id = $this->db->insertID();


                $student_data = [
                    'user_id' => $std_insert_id,
                    'affilate_agent_id' => isset($agent_id) ? $agent_id : NULL,
                    'name' => $post_data['name'],
                    'email' => $post_data['email'],
                    'date_of_birth' => $post_data['dob'],
                    'father_name' => $post_data['father_name'],
                    'guardian_mobile' => $post_data['guardian_mobile'],
                    'guardian_occupation' => $post_data['guardian_occupation'],
                    'gender' => $post_data['gender'],
                    'pincode' => $post_data['pincode'],
                    'district_id' => $post_data['district_id'],
                    'police_station' => $post_data['police_station'],
                    'class_id' => $post_data['class_id'],
                    'institute_name' => $post_data['institute_name'],
                    'stream_name' => $post_data['stream_name'],
                    'religion' => $post_data['religion'],
                    'address' => $post_data['address'],
                    'whatsapp_number' => $post_data['whatsapp_number'],
                ];

                $this->db->table('tbl_students')->insert($student_data);

                $student_id = $this->db->insertID();

                $inv_id = getInvoiceId();

                $invoice_history = [
                    'user_id' => $std_insert_id,
                    'uniq_invoice_id' => $inv_id,
                    'invoice_date' => date('y-m-d'),
                    'due_date' => date('Y-m-d'),
                    'subtotal' => $plan_details->plan_amount,
                    'discount' => 0,
                    'total' => $plan_details->plan_amount,
                    'status' => 'paid',
                ];

                $this->db->table('tbl_invoices')->insert($invoice_history);
                $insert_id = $this->db->insertID();

                if ($insert_id) {
                    $inv_item_data = [
                        'invoice_id' => $insert_id,
                        'item_description' => $plan_details->plan_name,
                        'quantity' => 1,
                        'unit_amount' => $plan_details->plan_amount,
                        'amount' => 1 * $plan_details->plan_amount
                    ];

                    $this->db->table('tbl_invoice_items')->insert($inv_item_data);

                    $currentTime = new DateTime();

                    $start_time = $currentTime->format('Y-m-d H:i:s');

                    $currentTime->modify("$plan_details->plan_duration months");

                    $end_time = $currentTime->format('Y-m-d H:i:s');

                    $subscription_data = [
                        'invoice_id' => $insert_id,
                        'user_id' => $std_insert_id,
                        'plan_id' => $plan_id,
                        'plan_services' => $plan_details->plan_name,
                        'subscription_status' => 'active',
                        'plan_interval' => 'month',
                        'plan_interval_count' => $plan_details->plan_duration,
                        'plan_period_start' => $start_time,
                        'plan_period_end' => $end_time
                    ];

                    $this->db->table('tbl_user_subscriptions')->insert($subscription_data);


                    $id_data = [
                        'username' => $username,
                        'name' => $post_data['name'],
                        'mobile' => $post_data['mobile'],
                        'address' => $post_data['address'],
                        'date_of_birth' => $post_data['dob'],
                        'plan_period_end' => $end_time,
                        'id' => $student_id,
                        'plan_name' => $plan_details->plan_name,
                        'plan_id' => $plan_id
                    ];

                    idCardGenerate($id_data);
                }

                $agent = getUserById($user->id);

                if ($agent->role_name == ROLE_AFFILATE_AGENT) {
                    //check the agent status 
                    $role_id = $agent->role_id;

                    //add commission according to the plan 
                    $plan_commission = getPlanCommission($role_id, $plan_id);

                    if (!is_null($plan_commission) && $plan_commission->amount > 0) {

                        $commission = $plan_commission->amount;

                        if (!is_null($agent->current_plan) && $agent->current_plan->plan_type == 'free_plan') {
                            $agent_commission = $commission / 2;
                        } else {
                            $agent_commission = $commission;
                        }

                        $sql = "UPDATE tbl_users
                                    SET wallet = wallet + $agent_commission
                                    WHERE id = $agent->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $agent->id,
                                'commission_from' => $std_insert_id,
                                'amount' => $agent_commission,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for student plan',
                                'ref_number' => $ref_no,
                                'txn_date' => date('Y-m-d')
                            ];

                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                        }

                        // find distibutor and check their plan status

                        $distributor = getUserById($agent->created_by);

                        if (!is_null($distributor)) {

                            // add commission according to the current plan

                            if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                                $commission_rate = 10;
                            } else {
                                $commission_rate = 30;
                            }
                            $distributor_commission = $agent_commission * $commission_rate / 100;

                            // create wallet txn record
                            // update walllet amount

                            $sql = "UPDATE tbl_users
                                    SET wallet = wallet + $distributor_commission
                                    WHERE id = $distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $distributor->id,
                                    'commission_from' => $agent->id,
                                    'amount' => $distributor_commission,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for student plan',
                                    'ref_number' => $ref_no,
                                    'txn_date' => date('Y-m-d')
                                ];

                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                            }

                            // find super distributor
                            $master_distributor = getUserById($distributor->created_by);

                            if (!is_null($master_distributor)) {
                                // add commission according to the current plan

                                if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                                    $commission_rate = 10;
                                } else {
                                    $commission_rate = 30;
                                }

                                $master_distributor_commission = $distributor_commission * $commission_rate / 100;

                                $sql = "UPDATE tbl_users
                                    SET wallet = wallet + $master_distributor_commission
                                    WHERE id = $master_distributor->id";

                                if ($this->db->query($sql)) {
                                    $n = 10;
                                    $ref_no = generateNumeric($n);

                                    $wallet_history = [
                                        'user_id' => $master_distributor->id,
                                        'commission_from' => $distributor->id,
                                        'amount' => $master_distributor_commission,
                                        'txn_type' => 'cr',
                                        'txn_comment' => 'commission for student plan',
                                        'ref_number' => $ref_no,
                                        'txn_date' => date('Y-m-d')
                                    ];

                                    $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                                }
                            }
                        }
                    }
                }

                $this->db->transComplete();

                return true;
            } else {
                $amount = $plan_details->plan_amount;
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

                $response = json_decode($response);

                return $response;
            }
        } catch (DatabaseException $e) {
            return false;
        }
    }

    /**
     * ADD student data after payment for plan 
     * 
     * @param array $post_data
     * @return bool
     */
    public function addStudentData($post_data)
    {
        $role = $this->db->query("SELECT * FROM tbl_roles WHERE role_name = 'student'")->getRow();

        $username = getNextStudentId('student');

        $user = getUserData();

        $userRole = getRole($user->role_id);

        if ($userRole == ROLE_AFFILATE_AGENT) {
            $agent_id = $user->id;
        }

        try {

            $plan_id = $post_data['plan_id'];

            $plan_details = $this->db->table('tbl_plans')
                ->where('id', $plan_id)
                ->get()
                ->getRow();

            $this->db->transException(true)->transStart();

            $user_data = [
                'username' => $username,
                'role_id' => $role->id,
                'name' => $post_data['name'],
                'email' => $post_data['email'],
                'mobile' => $post_data['mobile'],
                'password' => md5($post_data['password']),
                'is_active' => 1,
                'created_by' => $user->id
            ];

            $this->db->table('tbl_users')->insert($user_data);
            $std_insert_id = $this->db->insertID();

            $student_data = [
                'user_id' => $std_insert_id,
                'affilate_agent_id' => isset($agent_id) ? $agent_id : NULL,
                'name' => $post_data['name'],
                'email' => $post_data['email'],
                'date_of_birth' => $post_data['dob'],
                'father_name' => $post_data['father_name'],
                'guardian_mobile' => $post_data['guardian_mobile'],
                'guardian_occupation' => $post_data['guardian_occupation'],
                'gender' => $post_data['gender'],
                'pincode' => $post_data['pincode'],
                'district_id' => $post_data['district_id'],
                'police_station' => $post_data['police_station'],
                'class_id' => $post_data['class_id'],
                'institute_name' => $post_data['institute_name'],
                'stream_name' => $post_data['stream_name'],
                'religion' => $post_data['religion'],
                'address' => $post_data['address'],
                'whatsapp_number' => $post_data['whatsapp_number'],
            ];

            $this->db->table('tbl_students')->insert($student_data);
            $student_id = $this->db->insertID();

            $inv_id = getInvoiceId();

            $invoice_history = [
                'user_id' => $std_insert_id,
                'uniq_invoice_id' => $inv_id,
                'invoice_date' => date('y-m-d'),
                'due_date' => date('Y-m-d'),
                'subtotal' => $plan_details->plan_amount,
                'discount' => 0,
                'total' => $plan_details->plan_amount,
                'status' => 'paid',
            ];

            $this->db->table('tbl_invoices')->insert($invoice_history);
            $insert_id = $this->db->insertID();

            if ($insert_id) {
                $inv_item_data = [
                    'invoice_id' => $insert_id,
                    'item_description' => $plan_details->plan_name,
                    'quantity' => 1,
                    'unit_amount' => $plan_details->plan_amount,
                    'amount' => 1 * $plan_details->plan_amount
                ];

                $this->db->table('tbl_invoice_items')->insert($inv_item_data);

                $currentTime = new DateTime();

                $start_time = $currentTime->format('Y-m-d H:i:s');

                $currentTime->modify("$plan_details->plan_duration months");

                $end_time = $currentTime->format('Y-m-d H:i:s');

                $subscription_data = [
                    'invoice_id' => $insert_id,
                    'user_id' => $std_insert_id,
                    'plan_id' => $plan_id,
                    'plan_services' => $plan_details->plan_name,
                    'subscription_status' => 'active',
                    'plan_interval' => 'month',
                    'plan_interval_count' => $plan_details->plan_duration,
                    'plan_period_start' => $start_time,
                    'plan_period_end' => $end_time
                ];

                $this->db->table('tbl_user_subscriptions')->insert($subscription_data);

                $id_data = [
                    'username' => $username,
                    'name' => $post_data['name'],
                    'mobile' => $post_data['mobile'],
                    'address' => $post_data['address'],
                    'date_of_birth' => $post_data['dob'],
                    'plan_period_end' => $end_time,
                    'id' => $student_id,
                    'plan_name' => $plan_details->plan_name,
                    'plan_id' => $plan_id
                ];

                idCardGenerate($id_data);
            }

            $agent = getUserById($user->id);

            if ($agent->role_name == ROLE_AFFILATE_AGENT) {
                //check the agent status 
                $role_id = $agent->role_id;

                //add commission according to the plan 
                $plan_commission = getPlanCommission($role_id, $plan_id);

                if (!is_null($plan_commission) && $plan_commission->amount > 0) {

                    $commission = $plan_commission->amount;

                    if (!is_null($agent->current_plan) && $agent->current_plan->plan_type == 'free_plan') {
                        $agent_commission = $commission / 2;
                    } else {
                        $agent_commission = $commission;
                    }

                    $sql = "UPDATE tbl_users
                                SET wallet = wallet + $agent_commission
                                WHERE id = $agent->id";

                    if ($this->db->query($sql)) {
                        $n = 10;
                        $ref_no = generateNumeric($n);

                        $wallet_history = [
                            'user_id' => $agent->id,
                            'commission_from' => $std_insert_id,
                            'amount' => $agent_commission,
                            'txn_type' => 'cr',
                            'txn_comment' => 'commission for student plan',
                            'ref_number' => $ref_no,
                            'txn_date' => date('Y-m-d')
                        ];

                        $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                    }

                    // find distibutor and check their plan status

                    $distributor = getUserById($agent->created_by);

                    if (!is_null($distributor)) {

                        // add commission according to the current plan

                        if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                            $commission_rate = 10;
                        } else {
                            $commission_rate = 30;
                        }
                        $distributor_commission = $agent_commission * $commission_rate / 100;

                        // create wallet txn record
                        // update walllet amount

                        $sql = "UPDATE tbl_users
                                SET wallet = wallet + $distributor_commission
                                WHERE id = $distributor->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $distributor->id,
                                'commission_from' => $agent->id,
                                'amount' => $distributor_commission,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for student plan',
                                'ref_number' => $ref_no,
                                'txn_date' => date('Y-m-d')
                            ];

                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                        }

                        // find super distributor
                        $master_distributor = getUserById($distributor->created_by);

                        if (!is_null($master_distributor)) {
                            // add commission according to the current plan

                            if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                                $commission_rate = 10;
                            } else {
                                $commission_rate = 30;
                            }

                            $master_distributor_commission = $distributor_commission * $commission_rate / 100;

                            $sql = "UPDATE tbl_users
                                SET wallet = wallet + $master_distributor_commission
                                WHERE id = $master_distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $master_distributor->id,
                                    'commission_from' => $distributor->id,
                                    'amount' => $master_distributor_commission,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for student plan',
                                    'ref_number' => $ref_no,
                                    'txn_date' => date('Y-m-d')
                                ];

                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                            }
                        }
                    }
                }
            }

            $this->db->transComplete();

            return true;
        } catch (DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get students
     * 
     * @param string $query
     * @return array[object]
     */
    public function getStudents($query)
    {
        return $this->db->query($query)->getResult();
    }


    /**
     * Get single student data
     * 
     * @param int $id
     * @return object
     */
    public function getSingleData($id)
    {
        return $this->db->table('tbl_students')
            ->select('tbl_users.mobile as mobile, 
                    tbl_users.id as user_id,
                    tbl_districts.id as dist_id, 
                    tbl_districts.name as district_name, 
                    tbl_students.*,
                    tbl_classes.name as class_name')
            ->join('tbl_users', 'tbl_users.id = tbl_students.user_id')
            ->join('tbl_districts', 'tbl_districts.id = tbl_students.district_id', 'left')
            ->join('tbl_classes', 'tbl_classes.id = tbl_students.class_id', 'left')
            ->where('tbl_students.id', $id)
            ->get()
            ->getRow();
    }

    /**
     * Get plan by user id
     * 
     * @param int $user_id
     * @return object
     */
    public function getPlan($user_id)
    {
        return $this->db->table('tbl_user_subscriptions')
            ->select('tbl_plans.plan_name as plan_name,
                tbl_plans.plan_amount as plan_amount,
                tbl_user_subscriptions.*')
            ->join('tbl_plans', 'tbl_plans.id = tbl_user_subscriptions.plan_id')
            ->where('tbl_user_subscriptions.user_id', $user_id)
            ->where('tbl_user_subscriptions.subscription_status', 'active')
            ->get()
            ->getRow();
    }

    /**
     * Update student data
     * 
     * @param array $post_data
     * @param int $id
     * @return bool
     */
    public function updateData($post_data, $id)
    {
        $user = getUserData();
        try {
            $this->db->transException(true)->transStart();

            $user_data = [
                'name' => $post_data['name'],
                'email' => $post_data['email'],
                'updated_by' => $user->id
            ];

            $this->db->table('tbl_users')
                ->where('id', $post_data['user_id'])->update($user_data);

            $student_data = [
                'name' => $post_data['name'],
                'email' => $post_data['email'],
                'date_of_birth' => $post_data['dob'],
                'father_name' => $post_data['father_name'],
                'guardian_mobile' => $post_data['guardian_mobile'],
                'guardian_occupation' => $post_data['guardian_occupation'],
                'gender' => $post_data['gender'],
                'pincode' => $post_data['pincode'],
                'district_id' => $post_data['district_id'],
                'police_station' => $post_data['police_station'],
                'class_id' => $post_data['class_id'],
                'institute_name' => $post_data['institute_name'],
                'stream_name' => $post_data['stream_name'],
                'religion' => $post_data['religion'],
                'address' => $post_data['address'],
                'whatsapp_number' => $post_data['whatsapp_number'],
            ];

            $this->db->table('tbl_students')
                ->where('id', $id)->update($student_data);

            $student = $this->studentIdData($id);

            idCardGenerate($student);

            $this->db->transComplete();
            return true;
        } catch (DatabaseException $e) {
            return false;
        }
    }

    /**
     * Add plan for student or renew plan
     * 
     * @param int $plan_id
     * @param int $stud_id
     * @return bool
     */
    public function addSubscription($plan_id, $stud_id)
    {

        try {
            $this->db->transException(true)->transStart();

            $plan_details = $this->db->table('tbl_plans')
                ->where('id', $plan_id)
                ->get()
                ->getRow();

            $user = getUserData();

            $exist_sub = $this->db->table('tbl_user_subscriptions')
                ->where('user_id', $stud_id)
                ->where('subscription_status', 'active')
                ->get()
                ->getRow();

            if (!empty($exist_sub)) {
                $sub_data = [
                    'subscription_status' => 'cancelled'
                ];


                $this->db->table('tbl_user_subscriptions')
                    ->where('id', $exist_sub->id)
                    ->update($sub_data);
            }

            $inv_id = getInvoiceId();

            $invoice_history = [
                'user_id' => $stud_id,
                'uniq_invoice_id' => $inv_id,
                'invoice_date' => date('y-m-d'),
                'due_date' => date('Y-m-d'),
                'subtotal' => $plan_details->plan_amount,
                'discount' => 0,
                'total' => $plan_details->plan_amount,
                'status' => 'paid',
            ];

            $this->db->table('tbl_invoices')->insert($invoice_history);
            $insert_id = $this->db->insertID();

            if ($insert_id) {
                $inv_item_data = [
                    'invoice_id' => $insert_id,
                    'item_description' => $plan_details->plan_name,
                    'quantity' => 1,
                    'unit_amount' => $plan_details->plan_amount,
                    'amount' => 1 * $plan_details->plan_amount
                ];

                $this->db->table('tbl_invoice_items')->insert($inv_item_data);

                $currentTime = new DateTime();

                $start_time = $currentTime->format('Y-m-d H:i:s');

                $currentTime->modify("$plan_details->plan_duration months");

                $end_time = $currentTime->format('Y-m-d H:i:s');

                $subscription_data = [
                    'invoice_id' => $insert_id,
                    'user_id' => $stud_id,
                    'plan_id' => $plan_id,
                    'plan_services' => $plan_details->plan_name,
                    'subscription_status' => 'active',
                    'plan_interval' => 'month',
                    'plan_interval_count' => $plan_details->plan_duration,
                    'plan_period_start' => $start_time,
                    'plan_period_end' => $end_time
                ];

                $this->db->table('tbl_user_subscriptions')->insert($subscription_data);



                $student = $this->db->table('tbl_students')
                    ->join('tbl_users', 'tbl_users.id = tbl_students.user_id', 'inner')
                    ->join('tbl_user_subscriptions', 'tbl_user_subscriptions.user_id = tbl_students.user_id', 'inner')
                    ->join('tbl_plans', 'tbl_plans.id = tbl_user_subscriptions.plan_id', 'inner')
                    ->select('tbl_students.id,
                    tbl_students.name,
                    tbl_students.address,
                    tbl_students.date_of_birth,
                    tbl_students.id_card_front,
                    tbl_students.id_card_back,
                    tbl_students.id_card_data,
                    tbl_users.username,
                    tbl_users.mobile,
                    tbl_user_subscriptions.plan_period_end,
                    tbl_plans.plan_name,
                    tbl_plans.id as plan_id')
                    ->where('tbl_students.user_id', $stud_id)
                    ->where('tbl_user_subscriptions.subscription_status', 'active')
                    ->get()
                    ->getRowArray();

                idCardGenerate($student);
            }

            $agent = getUserById($user->id);

            if ($agent->role_name == ROLE_AFFILATE_AGENT) {
                //check the agent status 
                $role_id = $agent->role_id;

                //add commission according to the plan 
                $plan_commission = getPlanCommission($role_id, $plan_id);

                if (!is_null($plan_commission) && $plan_commission->amount > 0) {

                    $commission = $plan_commission->amount;

                    if (!is_null($agent->current_plan) && $agent->current_plan->plan_type == 'free_plan') {
                        $agent_commission = $commission / 2;
                    } else {
                        $agent_commission = $commission;
                    }

                    $sql = "UPDATE tbl_users
                                SET wallet = wallet + $agent_commission
                                WHERE id = $agent->id";

                    if ($this->db->query($sql)) {
                        $n = 10;
                        $ref_no = generateNumeric($n);

                        $wallet_history = [
                            'user_id' => $agent->id,
                            'commission_from' => $stud_id,
                            'amount' => $agent_commission,
                            'txn_type' => 'cr',
                            'txn_comment' => 'commission for student plan',
                            'ref_number' => $ref_no,
                            'txn_date' => date('Y-m-d')
                        ];

                        $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                    }

                    // find distibutor and check their plan status

                    $distributor = getUserById($agent->created_by);

                    if (!is_null($distributor)) {

                        // add commission according to the current plan

                        if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                            $commission_rate = 10;
                        } else {
                            $commission_rate = 30;
                        }
                        $distributor_commission = $agent_commission * $commission_rate / 100;

                        // create wallet txn record
                        // update walllet amount

                        $sql = "UPDATE tbl_users
                                SET wallet = wallet + $distributor_commission
                                WHERE id = $distributor->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $distributor->id,
                                'commission_from' => $agent->id,
                                'amount' => $distributor_commission,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for student plan',
                                'ref_number' => $ref_no,
                                'txn_date' => date('Y-m-d')
                            ];

                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                        }

                        // find super distributor
                        $master_distributor = getUserById($distributor->created_by);

                        if (!is_null($master_distributor)) {
                            // add commission according to the current plan

                            if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                                $commission_rate = 10;
                            } else {
                                $commission_rate = 30;
                            }

                            $master_distributor_commission = $distributor_commission * $commission_rate / 100;

                            $sql = "UPDATE tbl_users
                                SET wallet = wallet + $master_distributor_commission
                                WHERE id = $master_distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $master_distributor->id,
                                    'commission_from' => $distributor->id,
                                    'amount' => $master_distributor_commission,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for student plan',
                                    'ref_number' => $ref_no,
                                    'txn_date' => date('Y-m-d')
                                ];

                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                            }
                        }
                    }
                }
            }

            $this->db->transComplete();
            return true;
        } catch (DatabaseException $e) {
            return false;
        }
    }

    /**
     * Get invoice list by user id
     * 
     * @param int $user_id
     * @return array[object]
     */
    public function getInvoiceList($user_id)
    {
        $sql = "SELECT 
                    * 
                FROM 
                tbl_invoices
                WHERE user_id = ? 
                ORDER BY id DESC ";
        return $this->db->query($sql, [$user_id])->getResult();
    }

    /**
     * get Invoice all details by id 
     * 
     * @param int $inv_id
     * @return object
     */
    public function getInvoiceById($inv_id)
    {
        $sql = "SELECT 
                    u.name as user_name,
                    u.email as user_email,
                    u.mobile as mobile,
                    s.address as address,
                    it.item_description,
                    it.quantity,
                    it.amount,
                    us.plan_id,
                    p.plan_description,
                    p.plan_name,
                    i.*
                FROM 
                    tbl_invoices i
                JOIN tbl_users u ON u.id = i.user_id
                JOIN tbl_students s ON s.user_id = u.id
                JOIN tbl_invoice_items it ON it.invoice_id = i.id
                JOIN tbl_user_subscriptions us ON us.invoice_id = i.id
                JOIN tbl_plans p ON p.id = us.plan_id
                WHERE i.id = ?";
        return $this->db->query($sql, [$inv_id])->getRow();
    }

    /**
     * Get all services'
     * 
     * @return array[object]
     */
    public function getServices()
    {
        $sql = "SELECT 
                    id,
                    service_name
                FROM
                    tbl_services ";

        return $this->db->query($sql)->getResult();
    }

    /**
     * Get Enquiry details
     * 
     * @param string
     * @return array[object]
     */
    public function getEnquiry($query)
    {
        return $this->db->query($query)->getResult();
    }

    /**
     * get enquiry details by id
     * 
     * @param int $id
     * @return object
     */
    public function getEnquiryById($id)
    {
        return $this->db->table('tbl_enquires')
            ->where('id', $id)
            ->get()
            ->getRow();
    }

    /**
     * update status for enquiry
     * 
     * @param array $post_data
     * @param int  $id
     * @return bool
     */
    public function changeStatus($post_data, $id)
    {

        try {
            $this->db->transException(true)->transStart();

            $insert = $this->db->table('tbl_enquires')
                ->where('id', $id)
                ->update($post_data);

            if ($insert) {
                if ($post_data['status'] == 'completed') {
                    $enquiry_data = $this->getEnquiryById($id);
                    $service_commission = $enquiry_data->service_commission_amount;

                    if (isset($enquiry_data->created_by)) {
                        $student = getUserById($enquiry_data->created_by);

                        if (isset($student->created_by)) {
                            $agent = getUserById($student->created_by);

                            if ($agent->role_name == ROLE_AFFILATE_AGENT) {

                                if (!is_null($service_commission) && $service_commission > 0) {

                                    $commission = $service_commission;

                                    if (!is_null($agent->current_plan) && $agent->current_plan->plan_type == 'free_plan') {
                                        $agent_commission = $commission / 2;
                                    } else {
                                        $agent_commission = $commission;
                                    }

                                    $sql = "UPDATE tbl_users
                                            SET wallet = wallet + $agent_commission
                                            WHERE id = $agent->id";

                                    if ($this->db->query($sql)) {
                                        $n = 10;
                                        $ref_no = generateNumeric($n);

                                        $wallet_history = [
                                            'user_id' => $agent->id,
                                            'commission_from' => $student->id,
                                            'amount' => $agent_commission,
                                            'txn_type' => 'cr',
                                            'txn_comment' => 'commission for student service',
                                            'ref_number' => $ref_no,
                                            'txn_date' => date('Y-m-d')
                                        ];

                                        $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                                    }

                                    // find distibutor and check their plan status

                                    $distributor = getUserById($agent->created_by);

                                    if (!is_null($distributor)) {

                                        // add commission according to the current plan

                                        if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                                            $commission_rate = 10;
                                        } else {
                                            $commission_rate = 30;
                                        }
                                        $distributor_commission = $agent_commission * $commission_rate / 100;

                                        // create wallet txn record
                                        // update walllet amount

                                        $sql = "UPDATE tbl_users
                                            SET wallet = wallet + $distributor_commission
                                            WHERE id = $distributor->id";

                                        if ($this->db->query($sql)) {
                                            $n = 10;
                                            $ref_no = generateNumeric($n);

                                            $wallet_history = [
                                                'user_id' => $distributor->id,
                                                'commission_from' => $agent->id,
                                                'amount' => $distributor_commission,
                                                'txn_type' => 'cr',
                                                'txn_comment' => 'commission for student service',
                                                'ref_number' => $ref_no,
                                                'txn_date' => date('Y-m-d')
                                            ];

                                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                                        }

                                        // find super distributor
                                        $master_distributor = getUserById($distributor->created_by);

                                        if (!is_null($master_distributor)) {
                                            // add commission according to the current plan

                                            if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                                                $commission_rate = 10;
                                            } else {
                                                $commission_rate = 30;
                                            }

                                            $master_distributor_commission = $distributor_commission * $commission_rate / 100;

                                            $sql = "UPDATE tbl_users
                                                SET wallet = wallet + $master_distributor_commission
                                                WHERE id = $master_distributor->id";

                                            if ($this->db->query($sql)) {
                                                $n = 10;
                                                $ref_no = generateNumeric($n);

                                                $wallet_history = [
                                                    'user_id' => $master_distributor->id,
                                                    'commission_from' => $distributor->id,
                                                    'amount' => $master_distributor_commission,
                                                    'txn_type' => 'cr',
                                                    'txn_comment' => 'commission for student service',
                                                    'ref_number' => $ref_no,
                                                    'txn_date' => date('Y-m-d')
                                                ];

                                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $this->db->transComplete();
            return true;
        } catch (DatabaseException $e) {
            return false;
        }
    }


    public function studentIdData($id = null)
    {
        return $this->db->table('tbl_students')
            ->join('tbl_users', 'tbl_users.id = tbl_students.user_id', 'inner')
            ->join('tbl_user_subscriptions', 'tbl_user_subscriptions.user_id = tbl_students.user_id', 'inner')
            ->join('tbl_plans', 'tbl_plans.id = tbl_user_subscriptions.plan_id', 'inner')
            ->select('tbl_students.id,
                tbl_students.name,
                tbl_students.address,
                tbl_students.date_of_birth,
                tbl_students.id_card_front,
                tbl_students.id_card_back,
                tbl_students.id_card_data,
                tbl_users.username,
                tbl_users.mobile,
                tbl_user_subscriptions.plan_period_end,
                tbl_plans.plan_name,
                tbl_plans.id as plan_id')
            ->where('tbl_students.id', $id)
            ->where('tbl_user_subscriptions.subscription_status', 'active')
            ->get()
            ->getRowArray();
    }
}
