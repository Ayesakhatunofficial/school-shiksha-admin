<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\I18n\Time;
use DateTime;

class SubscriptionModel extends Model
{
    public function checkSubscription()
    {
        try {
            $this->db->transException(true)->transStart();

            $sql = "SELECT 
                        * 
                    FROM 
                        tbl_user_subscriptions
                    WHERE subscription_status = 'active' AND CURTIME() > plan_period_end";

            $subscriptions = $this->db->query($sql)->getResult();

            if (!empty($subscriptions)) {
                foreach ($subscriptions as $sub) {
                    $inactive_data = [
                        'subscription_status' => 'expired'
                    ];

                    $inactive = $this->db->table('tbl_user_subscriptions')
                        ->where('id', $sub->id)
                        ->update($inactive_data);

                    if ($inactive) {

                        $user = $this->db->table('tbl_users')
                            ->where('id', $sub->user_id)
                            ->get()
                            ->getRow();

                        $plan = $this->db->table('tbl_plans')
                            ->where('role_id', $user->role_id)
                            ->where('plan_amount', 0)
                            ->get()
                            ->getRow();

                        $inv_id = getInvoiceId();

                        $invoice_history = [
                            'user_id' => $sub->user_id,
                            'uniq_invoice_id' => $inv_id,
                            'invoice_date' => date('y-m-d'),
                            'due_date' => date('Y-m-d'),
                            'subtotal' => $plan->plan_amount,
                            'discount' => 0,
                            'total' => $plan->plan_amount,
                            'status' => 'paid',
                        ];

                        $this->db->table('tbl_invoices')->insert($invoice_history);
                        $insert_id = $this->db->insertID();

                        if ($insert_id) {
                            $inv_item_data = [
                                'invoice_id' => $insert_id,
                                'item_description' => $plan->plan_name,
                                'quantity' => 1,
                                'unit_amount' => $plan->plan_amount,
                                'amount' => 1 * $plan->plan_amount
                            ];

                            $this->db->table('tbl_invoice_items')->insert($inv_item_data);

                            $currentTime = new DateTime();
                            $start_time = $currentTime->format('Y-m-d H:i:s');
                            $currentTime->modify("$plan->plan_duration months");
                            $plan_end_time = $currentTime->format('Y-m-d H:i:s');

                            $active_data = [
                                'invoice_id' => $insert_id,
                                'user_id' => $sub->user_id,
                                'plan_id' => $plan->id,
                                'plan_services' => $plan->plan_name,
                                'subscription_status' => 'active',
                                'plan_interval' => 'month',
                                'plan_interval_count' => $plan->plan_duration,
                                'plan_period_start' => $start_time,
                                'plan_period_end' => $plan_end_time
                            ];

                            $this->db->table('tbl_user_subscriptions')->insert($active_data);
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
}
