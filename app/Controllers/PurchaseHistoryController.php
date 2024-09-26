<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;

class PurchaseHistoryController extends BaseController
{
    public function index()
    {
        if ($this->request->isAJAX()) {
            $model = new InvoiceModel();
            $offset = intval($this->request->getGet('start')) ?? 0;
            $limit = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);

            $from_date = $this->request->getGet('columns')[1]['search']['value'];
            $to_date = $this->request->getGet('columns')[2]['search']['value'];

            $records = $model->getPurchaseHistory(
                $limit,
                $offset,
                $searchValue,
                $from_date,
                $to_date
            );

            if (!empty($records)) {
                foreach ($records['data'] as $row) {
                    $row->amount = number_format($row->amount);
                    $row->status = sprintf('<a><label class="badge badge-success">%s</label></a>', ucfirst($row->status));
                    $row->action = '
                            <a href="' . base_url('purchase-history/' . $row->id) . '" class="btn a-btn btn-inverse-success btn-rounded btn-icon" title="View">
                                <i class="mdi mdi-eye"></i>
                            </a>
                        ';
                }
            }

            $output = array(
                'draw' => intval($this->request->getGet('draw')),
                'recordsTotal' => $records['recordsTotal'],
                'recordsFiltered' => $records['recordsFiltered'],
                'data' => $records['data'],
            );

            echo json_encode($output);
            return;
        }

        return view(
            'purchase-history/index'
        );
    }

    public function details($invoice_id)
    {
        $model = new InvoiceModel();
        $purchase = $model->getPurchaseDetailsById($invoice_id);

        return view('purchase-history/details', [
            'purchase' => $purchase
        ]);
    }

    public function totalPurchase()
    {
        $model = new InvoiceModel();
        $total_amount = $model->getTotalPurchaseAmount(
            $this->request->getVar('from_date'),
            $this->request->getVar('to_date'),
            $this->request->getVar('search_string')
        );

        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'data'   => [
                'total' => $total_amount
            ] 
        ]);
        die;
    }
}