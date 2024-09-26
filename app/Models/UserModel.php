<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use DateTime;

class UserModel extends Model
{
    protected $table = 'tbl_users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'role_id',
        'username',
        'name',
        'email',
        'mobile',
        'password',
        'raw_password',
        'wallet',
        'reset_otp',
        'otp_valid_till',
        'last_login',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];


    /**
     * Get roles according to user role
     * 
     * @return array[object]
     */
    public function fetchRoles()
    {
        $role = getRole();

        if ($role == ROLE_SUPER_ADMIN) {
            $sql = "SELECT 
                        *
                    FROM 
                        tbl_roles
                    WHERE role_name NOT IN ('super_admin', 'student')";
        } else if ($role == ROLE_MASTER_DISTRIBUTOR) {

            $role_name = ROLE_DISTRIBUTOR;

            $sql = "SELECT 
                        *
                    FROM 
                        tbl_roles
                    WHERE role_name = '$role_name'";
        } else if ($role == ROLE_DISTRIBUTOR) {

            $role_name = ROLE_AFFILATE_AGENT;

            $sql = "SELECT 
                        *
                    FROM 
                        tbl_roles
                    WHERE role_name = '$role_name'";
        }

        return $this->db->query($sql)->getResult();
    }

    /**
     * Get users by role id 
     * 
     * @param int $id
     * @return array[array]
     */
    public function getUsersData($id)
    {
        $user = getUserData();
        $role = getRole($user->role_id);
        if ($role == ROLE_SUPER_ADMIN) {
            $sql = "SELECT 
                    p.plan_name,
                    r.role_name,
                    u.*
                FROM 
                    tbl_users u
                JOIN tbl_roles r ON r.id = u.role_id
                JOIN tbl_user_subscriptions s ON u.id = s.user_id
                JOIN tbl_plans p ON p.id = s.plan_id
                WHERE u.role_id = ? AND s.subscription_status = 'active'
                ORDER BY u.id DESC ";
            return $this->db->query($sql, [$id])->getResultArray();
        } else {
            $sql = "SELECT 
                    p.plan_name,
                    r.role_name,
                    u.*
                FROM 
                    tbl_users u
                JOIN tbl_roles r ON r.id = u.role_id
                JOIN tbl_user_subscriptions s ON u.id = s.user_id
                JOIN tbl_plans p ON p.id = s.plan_id
                WHERE u.role_id = ? 
                AND s.subscription_status = 'active' 
                AND u.created_by = ?
                ORDER BY u.id DESC ";
            return $this->db->query($sql, [$id, $user->id])->getResultArray();
        }
    }

    /**
     * Get plan by user id
     * 
     * @param int $user_id
     * @return array[object]
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
     * Get user by id
     * 
     * @param int $id
     * @return array
     */
    public function getUser($id)
    {
        return $this->db->table('tbl_users')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Add or renew  plan for users
     * 
     * @param int $plan_id
     * @param int $user_id
     * @return bool 
     */
    public function addSubscription($plan_id, $user_id)
    {
        try {
            $this->db->transException(true)->transStart();

            $plan_details = $this->db->table('tbl_plans')
                ->where('id', $plan_id)
                ->get()
                ->getRow();

            $exist_sub = $this->db->table('tbl_user_subscriptions')
                ->where('user_id', $user_id)
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
                'user_id' => $user_id,
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
                    'user_id' => $user_id,
                    'plan_id' => $plan_id,
                    'plan_services' => $plan_details->plan_name,
                    'subscription_status' => 'active',
                    'plan_interval' => 'month',
                    'plan_interval_count' => $plan_details->plan_duration,
                    'plan_period_start' => $start_time,
                    'plan_period_end' => $end_time
                ];

                $this->db->table('tbl_user_subscriptions')->insert($subscription_data);
            }

            $user = getUserById($user_id);

            if ($user->role_name == ROLE_AFFILATE_AGENT) {
                // find distibutor and check their plan status

                $distributor = getUserById($user->created_by);

                if (!is_null($distributor)) {

                    // add commission according to the current plan
                    $role_id = $distributor->role_id;

                    $plan_commission = getPlanCommission($role_id, $plan_id);

                    if (!is_null($plan_commission) && $plan_commission->amount > 0) {
                        $commission = $plan_commission->amount;

                        if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                            $commission_rate = 10;
                            $commission_amount = $commission * $commission_rate / 100;
                        } else {
                            $commission_amount = $commission;
                        }

                        // create wallet txn record
                        // update walllet amount

                        $sql = "UPDATE tbl_users
                        SET wallet = wallet + $commission_amount
                        WHERE id = $distributor->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $distributor->id,
                                'commission_from' => $user_id,
                                'amount' => $commission_amount,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for user plan',
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

                            $commission_amount_master = $commission_amount * $commission_rate / 100;

                            $sql = "UPDATE tbl_users
                                    SET wallet = wallet + $commission_amount_master
                                    WHERE id = $master_distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $master_distributor->id,
                                    'commission_from' => $distributor->id,
                                    'amount' => $commission_amount_master,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for user plan',
                                    'ref_number' => $ref_no,
                                    'txn_date' => date('Y-m-d')
                                ];

                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                            }
                        }
                    }
                }
            } else if ($user->role_name == ROLE_DISTRIBUTOR) {
                // find super distributor
                $master_distributor = getUserById($user->created_by);
                if (!is_null($master_distributor)) {
                    // add commission according to the current plan

                    $role_id = $master_distributor->role_id;

                    $plan_commission = getPlanCommission($role_id, $plan_id);

                    if (!is_null($plan_commission) && $plan_commission->amount > 0) {
                        $commission = $plan_commission->amount;

                        if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                            $commission_rate = 10;
                            $commission_amount = $commission * $commission_rate / 100;
                        } else {
                            $commission_amount = $commission;
                        }

                        // create wallet txn record
                        // update walllet amount

                        $sql = "UPDATE tbl_users
                        SET wallet = wallet + $commission_amount
                        WHERE id = $master_distributor->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $master_distributor->id,
                                'commission_from' => $user_id,
                                'amount' => $commission_amount,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for user plan',
                                'ref_number' => $ref_no,
                                'txn_date' => date('Y-m-d')
                            ];

                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                        }
                    }
                }
            } else if ($user->role_name == ROLE_MASTER_DISTRIBUTOR) {
            }

            $this->db->transComplete();
            return true;
        } catch (DatabaseException $e) {
            return false;
        }
    }

    /**
     * Add users with plan 
     * 
     * @param array $post_data
     * @return array[object]|bool
     */
    public function addUser($post_data)
    {
        $session = session();

        $session_data = [
            'post_data' => $post_data
        ];

        $session->set($session_data);

        try {

            $plan_id = $post_data['plan_id'];

            $plan_details = $this->db->table('tbl_plans')
                ->where('id', $plan_id)
                ->get()
                ->getRow();


            if ($plan_details->plan_amount == 0) {

                $this->db->transException(true)->transStart();

                $user_data = [
                    'username' => $post_data['username'],
                    'role_id' => $post_data['role_id'],
                    'name' => $post_data['name'],
                    'email' => $post_data['email'],
                    'mobile' => $post_data['mobile'],
                    'password' => $post_data['password'],
                    'raw_password' => $post_data['raw_password'],
                    'is_active' => 1,
                    'wallet' => 0,
                    'created_by' => $post_data['created_by']
                ];

                $this->db->table('tbl_users')->insert($user_data);
                $user_insert_id = $this->db->insertID();

                $inv_id = getInvoiceId();

                $invoice_history = [
                    'user_id' => $user_insert_id,
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
                        'user_id' => $user_insert_id,
                        'plan_id' => $plan_id,
                        'plan_services' => $plan_details->plan_name,
                        'subscription_status' => 'active',
                        'plan_interval' => 'month',
                        'plan_interval_count' => $plan_details->plan_duration,
                        'plan_period_start' => $start_time,
                        'plan_period_end' => $end_time
                    ];

                    $this->db->table('tbl_user_subscriptions')->insert($subscription_data);
                }

                $role_name = getRole($post_data['role_id']);

                if ($role_name == ROLE_AFFILATE_AGENT) {
                    // find distibutor and check their plan status

                    $distributor = getUserById($post_data['created_by']);

                    if (!is_null($distributor)) {

                        // add commission according to the current plan
                        $role_id = $distributor->role_id;

                        $plan_commission = getPlanCommission($role_id, $plan_id);

                        if (!is_null($plan_commission) && $plan_commission->amount > 0) {
                            $commission = $plan_commission->amount;

                            if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                                $commission_rate = 10;
                                $commission_amount = $commission * $commission_rate / 100;
                            } else {
                                $commission_amount = $commission;
                            }

                            // create wallet txn record
                            // update walllet amount

                            $sql = "UPDATE tbl_users
                            SET wallet = wallet + $commission_amount
                            WHERE id = $distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $distributor->id,
                                    'commission_from' => $user_insert_id,
                                    'amount' => $commission_amount,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for user plan',
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

                                $commission_amount_master = $commission_amount * $commission_rate / 100;

                                $sql = "UPDATE tbl_users
                                        SET wallet = wallet + $commission_amount_master
                                        WHERE id = $master_distributor->id";

                                if ($this->db->query($sql)) {
                                    $n = 10;
                                    $ref_no = generateNumeric($n);

                                    $wallet_history = [
                                        'user_id' => $master_distributor->id,
                                        'commission_from' => $distributor->id,
                                        'amount' => $commission_amount_master,
                                        'txn_type' => 'cr',
                                        'txn_comment' => 'commission for user plan',
                                        'ref_number' => $ref_no,
                                        'txn_date' => date('Y-m-d')
                                    ];

                                    $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                                }
                            }
                        }
                    }
                } else if ($role_name == ROLE_DISTRIBUTOR) {
                    // find super distributor
                    $master_distributor = getUserById($post_data['created_by']);
                    if (!is_null($master_distributor)) {
                        // add commission according to the current plan

                        $role_id = $master_distributor->role_id;

                        $plan_commission = getPlanCommission($role_id, $plan_id);

                        if (!is_null($plan_commission) && $plan_commission->amount > 0) {
                            $commission = $plan_commission->amount;

                            if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                                $commission_rate = 10;
                                $commission_amount = $commission * $commission_rate / 100;
                            } else {
                                $commission_amount = $commission;
                            }

                            // create wallet txn record
                            // update walllet amount

                            $sql = "UPDATE tbl_users
                            SET wallet = wallet + $commission_amount
                            WHERE id = $master_distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $master_distributor->id,
                                    'commission_from' => $user_insert_id,
                                    'amount' => $commission_amount,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for user plan',
                                    'ref_number' => $ref_no,
                                    'txn_date' => date('Y-m-d')
                                ];

                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                            }
                        }
                    }
                } else if ($role_name == ROLE_MASTER_DISTRIBUTOR) {
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

    public function addUserData($post_data)
    {
        try {
            $this->db->transException(true)->transStart();

            $plan_id = $post_data['plan_id'];

            $plan_details = $this->db->table('tbl_plans')
                ->where('id', $plan_id)
                ->get()
                ->getRow();

            $user_data = [
                'username' => $post_data['username'],
                'role_id' => $post_data['role_id'],
                'name' => $post_data['name'],
                'email' => $post_data['email'],
                'mobile' => $post_data['mobile'],
                'password' => $post_data['password'],
                'raw_password' => $post_data['raw_password'],
                'is_active' => 1,
                'wallet' => 0,
                'created_by' => $post_data['created_by']
            ];

            $this->db->table('tbl_users')->insert($user_data);
            $user_insert_id = $this->db->insertID();

            $inv_id = getInvoiceId();

            $invoice_history = [
                'user_id' => $user_insert_id,
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
                    'user_id' => $user_insert_id,
                    'plan_id' => $plan_id,
                    'plan_services' => $plan_details->plan_name,
                    'subscription_status' => 'active',
                    'plan_interval' => 'month',
                    'plan_interval_count' => $plan_details->plan_duration,
                    'plan_period_start' => $start_time,
                    'plan_period_end' => $end_time
                ];

                $this->db->table('tbl_user_subscriptions')->insert($subscription_data);
            }

            $role_name = getRole($post_data['role_id']);

            if ($role_name == ROLE_AFFILATE_AGENT) {
                // find distibutor and check their plan status

                $distributor = getUserById($post_data['created_by']);

                if (!is_null($distributor)) {

                    // add commission according to the current plan
                    $role_id = $distributor->role_id;

                    $plan_commission = getPlanCommission($role_id, $plan_id);

                    if (!is_null($plan_commission) && $plan_commission->amount > 0) {
                        $commission = $plan_commission->amount;

                        if (!is_null($distributor->current_plan) && $distributor->current_plan->plan_type == 'free_plan') {
                            $commission_rate = 10;
                            $commission_amount = $commission * $commission_rate / 100;
                        } else {
                            $commission_amount = $commission;
                        }

                        // create wallet txn record
                        // update walllet amount

                        $sql = "UPDATE tbl_users
                            SET wallet = wallet + $commission_amount
                            WHERE id = $distributor->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $distributor->id,
                                'commission_from' => $user_insert_id,
                                'amount' => $commission_amount,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for user plan',
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

                            $commission_amount_master = $commission_amount * $commission_rate / 100;

                            $sql = "UPDATE tbl_users
                                        SET wallet = wallet + $commission_amount_master
                                        WHERE id = $master_distributor->id";

                            if ($this->db->query($sql)) {
                                $n = 10;
                                $ref_no = generateNumeric($n);

                                $wallet_history = [
                                    'user_id' => $master_distributor->id,
                                    'commission_from' => $distributor->id,
                                    'amount' => $commission_amount_master,
                                    'txn_type' => 'cr',
                                    'txn_comment' => 'commission for user plan',
                                    'ref_number' => $ref_no,
                                    'txn_date' => date('Y-m-d')
                                ];

                                $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                            }
                        }
                    }
                }
            } else if ($role_name == ROLE_DISTRIBUTOR) {
                // find super distributor
                $master_distributor = getUserById($post_data['created_by']);
                if (!is_null($master_distributor)) {
                    // add commission according to the current plan

                    $role_id = $master_distributor->role_id;

                    $plan_commission = getPlanCommission($role_id, $plan_id);

                    if (!is_null($plan_commission) && $plan_commission->amount > 0) {
                        $commission = $plan_commission->amount;

                        if (!is_null($master_distributor->current_plan) && $master_distributor->current_plan->plan_type == 'free_plan') {
                            $commission_rate = 10;
                            $commission_amount = $commission * $commission_rate / 100;
                        } else {
                            $commission_amount = $commission;
                        }

                        // create wallet txn record
                        // update walllet amount

                        $sql = "UPDATE tbl_users
                            SET wallet = wallet + $commission_amount
                            WHERE id = $master_distributor->id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $master_distributor->id,
                                'commission_from' => $user_insert_id,
                                'amount' => $commission_amount,
                                'txn_type' => 'cr',
                                'txn_comment' => 'commission for user plan',
                                'ref_number' => $ref_no,
                                'txn_date' => date('Y-m-d')
                            ];

                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
                        }
                    }
                }
            } else if ($role_name == ROLE_MASTER_DISTRIBUTOR) {
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
                WHERE user_id = ?";
        return $this->db->query($sql, [$user_id])->getResult();
    }

    /**
     * Get wallet history
     * 
     * @param string $query
     * @return array[object]
     */
    public function getWalletList($query)
    {
        return $this->db->query($query)->getResult();
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
                JOIN tbl_invoice_items it ON it.invoice_id = i.id
                JOIN tbl_user_subscriptions us ON us.invoice_id = i.id
                JOIN tbl_plans p ON p.id = us.plan_id
                WHERE i.id = ?";
        return $this->db->query($sql, [$inv_id])->getRow();
    }


    public function getStudent($agents_id)
    {
        $role_id = getRoleId(ROLE_STUDENT);
        $sql = "SELECT 
                    COUNT(id) as total_student
                FROM 
                    tbl_users 
                WHERE role_id = $role_id AND created_by IN $agents_id ";

        return $this->db->query($sql)->getRow();
    }

    public function getDistributor($id)
    {
        $role_id = getRoleId(ROLE_DISTRIBUTOR);
        $sql = "SELECT 
                    COUNT(id) as total_distributor
                FROM 
                    tbl_users 
                WHERE role_id = ? AND created_by = ? ";

        return $this->db->query($sql, [$role_id, $id])->getRow();
    }

    public function getAgent($distributors_id)
    {
        $role_id = getRoleId(ROLE_AFFILATE_AGENT);


        $sql = "SELECT 
                    COUNT(id) as total_agent
                FROM 
                    tbl_users 
                WHERE role_id = $role_id AND created_by IN $distributors_id ";

        return $this->db->query($sql)->getRow();
    }

    /**
     * Get total users id
     * 
     * @param int $user_id
     * @return object|array
     */
    public function getSubordinateUsers($user_id)
    {
        $role_id = getRoleId(ROLE_STUDENT);

        $sql = "SELECT * FROM tbl_users WHERE role_id != $role_id AND created_by = $user_id";
        $result = $this->db->query($sql)->getResult();

        $ids = array();

        foreach ($result as $user) {
            $ids[] = $user->id;
        }

        foreach ($result as $user) {
            $ids = array_merge($ids, $this->getSubordinateUsers($user->id));
        }

        return $ids;
    }


    public function getUserById($id)
    {
        return $this->db->table('tbl_users')
            ->where('id', $id)
            ->get()
            ->getRow();
    }


    /**
     * Add withdraw request
     * 
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function addWithdrawRequest($data, $id)
    {
        $input = [
            'amount' => $data['amount'],
            'request_date' => date('Y-m-d'),
            'status' => 'pending',
            'request_by' => $id
        ];

        return $this->db->table('tbl_withdrawals')->insert($input);
    }

    /**
     * Get withdraw request data by user id 
     * 
     * @param int $id
     * @return array[object]
     */
    public function getWithdrawals($id)
    {
        return $this->db->table('tbl_withdrawals')
            ->where('request_by', $id)
            ->get()
            ->getResult();
    }

    /**
     * Get withdraw request
     * 
     * @param string $query
     * @return array[object]
     */
    public function getWithdraw($query)
    {
        return $this->db->query($query)->getResult();
    }

    /**
     * Get withdraw data by id
     * 
     * @param int $id
     * @return object
     */
    public function getWithdrawById($id)
    {
        $sql = "SELECT 
                        u.name,
                        u.email,
                        u.mobile,
                        u.wallet,
                        w.*
                    FROM 
                        tbl_withdrawals w
                    JOIN tbl_users u ON u.id = w.request_by
                    WHERE w.id = $id ";
        return $this->db->query($sql)->getRow();
    }

    /**
     * Update status for withdraw request
     * 
     * @param array $post_data
     * @param int  $id
     * @return bool
     */
    public function changeStatus($post_data, $id, $amount, $user_id)
    {
        try {
            $this->db->transException(true)->transStart();

            $insert = $this->db->table('tbl_withdrawals')
                ->where('id', $id)
                ->update($post_data);

            if ($insert) {
                if ($post_data['status'] == 'approved') {

                    $user = getUserById($user_id);

                    if ($user->wallet > MIN_AMOUNT) {

                        $sql = "UPDATE tbl_users
                            SET wallet = wallet - $amount
                            WHERE id = $user_id";

                        if ($this->db->query($sql)) {
                            $n = 10;
                            $ref_no = generateNumeric($n);

                            $wallet_history = [
                                'user_id' => $user_id,
                                'amount' => $amount,
                                'txn_type' => 'dr',
                                'txn_comment' => 'Wallet balance withdraw',
                                'ref_number' => $ref_no,
                                'txn_date' => date('Y-m-d')
                            ];

                            $this->db->table('tbl_wallet_txn_history')->insert($wallet_history);
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
     * Add or Update user bank details
     * 
     * @param int $user_id
     * @param array $bank_details
     * @param string $bank_photo
     * 
     *@return object
     */
    public function addBankDetails($user_id, $bank_details, $bank_photo = NULL)
    {
        $id = $bank_details['id'];
        $data = [
            'user_id' => $user_id,
            'bank_name' => $bank_details['bank_name'],
            'branch_name' => $bank_details['branch_name'],
            'account_number' => $bank_details['account_number'],
            'ifsc_code' => $bank_details['ifsc_code'],
            'passbook_photo' => $bank_photo
        ];

        if ($id != '' || $id != NULL) {
            return $this->db->table('tbl_bank_details')
                ->where('id', $id)
                ->update($data);
        } else {
            return $this->db->table('tbl_bank_details')
                ->insert($data);
        }
    }

    /**
     * Get user bank details by user id
     * 
     * @param int $user_id
     * @return object
     */
    public function getBankDetails($user_id)
    {
        return $this->db->table('tbl_bank_details')
            ->where('user_id', $user_id)
            ->get()
            ->getRow();
    }

    /**
     * Get commissions by user role id 
     * 
     * @param int $role_id
     * @return array[object]
     */
    public function getUserCommissions($role_id)
    {
        $sql = "SELECT 
                    s.service_name as name,
                    sc.amount as commission_amount
                FROM tbl_service_comissions sc
                INNER JOIN tbl_services s ON s.id = sc.service_id
                WHERE sc.role_id = ? 
                
                UNION 
                
                SELECT 
                    p.plan_name as name,
                    pc.amount as commission_amount
                FROM
                    tbl_plan_commission pc
                INNER JOIN tbl_plans p ON p.id = pc.plan_id
                WHERE pc.role_id = ? ";

        return $this->db->query($sql, [$role_id, $role_id])->getResult();
    }
}
