<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table            = 'tbl_invoices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get purchase history
     * 
     * @param int $limit
     * @param int $offset
     * @param string $search_string
     * @param string $from_date
     * @param string $to_date
     * 
     * @return array
     */
    public function getPurchaseHistory($limit, $offset, $search_string, $from_date = '', $to_date = '')
    {
        $data = [];

        // find total records count
        $sql = "SELECT
            IFNULL(COUNT(*), 0) AS total
        FROM tbl_invoices
        WHERE total > 0";

        $result = $this->db->query($sql)->getRow();
        $data['recordsTotal'] = $result->total;


        $where_clause = " WHERE 1 AND i.total > 0 ";
        if (!empty($search_string)) {
            $like = " LIKE '%" . htmlspecialchars(trim($search_string)) . "%'";
            $where_clause .= " AND (
                i.uniq_invoice_id $like
                OR i.payment_txn_id $like
                OR u.name $like
                OR i.invoice_date $like
            ) ";
        }

        if( $from_date != '' && $to_date != '' ) {
            $where_clause .= " AND i.invoice_date BETWEEN '$from_date' AND '$to_date' ";
        }

        $sql = "SELECT
            COUNT(i.uniq_invoice_id) AS total
        FROM tbl_invoices i
        LEFT JOIN tbl_users u ON u.id = i.user_id
        $where_clause";
        
        $result = $this->db->query($sql)->getRow();
        $data['recordsFiltered'] = $result->total;

        // find records
        $sql = "SELECT
            i.id,
            i.uniq_invoice_id AS invoice_number,
            i.payment_txn_id AS txn_id,
            u.name AS customer_name,
            i.invoice_date AS purchase_date,
            i.total AS amount,
            i.status
        FROM tbl_invoices i
        LEFT JOIN tbl_users u ON u.id = i.user_id
        $where_clause
        ORDER BY i.invoice_date DESC
        LIMIT $limit
        OFFSET $offset";

        $result = $this->db->query($sql)->getResult();

        $data['data'] = $result;

        return $data;
    }

    /**
     * Get purchase details id
     * 
     * @param int $invoice_id
     * @return object|null
     */
    public function getPurchaseDetailsById($invoice_id)
    {
        // find purchse details
        $sql = "SELECT
            i.*,
            u.name AS customer_name
        FROM tbl_invoices i
        LEFT JOIN tbl_users u ON u.id = i.user_id
        WHERE i.id = $invoice_id";

        $purchase = $this->db->query($sql)->getRow();

        if( is_null($purchase) ) {
            return;
        }

        // find purchase detials
        $sql = "SELECT 
            *
        FROM tbl_invoice_items
        WHERE invoice_id = $invoice_id";

        $purchase->items = $this->db->query($sql)->getResult();

        return $purchase;
    }

    /**
     * Get total purchase amount
     * 
     * @param string $from_date
     * @param string $to_date
     * @param string $search_string
     * @return string
     */
    public function getTotalPurchaseAmount($from_date='', $to_date='', $search_string='')
    {
        $where_clause = " WHERE 1 ";

        if( $from_date != '' && $to_date != '' ) {
            $where_clause .= " AND i.invoice_date BETWEEN '$from_date' AND '$to_date' ";
        }

        if (!empty($search_string)) {
            $like = " LIKE '%" . htmlspecialchars(trim($search_string)) . "%'";
            $where_clause .= " AND (
                i.uniq_invoice_id $like
                OR i.payment_txn_id $like
                OR u.name $like
                OR i.invoice_date $like
            ) ";
        }

        $sql = "SELECT
            IFNULL(SUM(i.total), 0) AS total
        FROM tbl_invoices i
        LEFT JOIN tbl_users u ON u.id = i.user_id
        $where_clause";

        $result = $this->db->query($sql)->getRow();

        return sprintf('₹ %s', number_format($result->total));
    }

}
