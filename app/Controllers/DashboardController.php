<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use App\Models\UserModel;
use DateTime;

class DashboardController extends BaseController
{

    public function dashboard()
    {
        $model = new DashboardModel();

        $from_date = $this->request->getVar('from_date');
        $to_date = $this->request->getVar('to_date');

        $data = [];

        $data['banners'] = $model->getBanners();
        $data['agent'] = $model->getAgent($from_date, $to_date);
        $data['master_distributor'] = $model->getMasterDistributor($from_date, $to_date);
        $data['distributor'] = $model->getDistributor($from_date, $to_date);
        $data['student'] = $model->getStudent($from_date, $to_date);
        $data['active_student'] = $model->getActiveStudent($from_date, $to_date);
        $data['active_agent'] = $model->getActiveAgent($from_date, $to_date);
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;


        return view('index', $data);
    }
    public function studentQuery()
    {
        $model = new DashboardModel();
        $data['query'] =  $model->studentQuery();
        return view('student_query/view', $data);
    }

    public function careerGuidence()
    {
        if ($this->request->isAJAX()) {
            $model = new DashboardModel();

            // Retrieve DataTables parameters from the request
            $draw = intval($this->request->getVar('draw'));
            $start = intval($this->request->getVar('start'));
            $length = intval($this->request->getVar('length'));
            $searchValue = $this->request->getVar('search')['value'];

            // Fetch data from the model
            $data = $model->careerGuidenceData($start, $length, $searchValue);
            $totalRecords = $model->countAllData();
            $filteredRecords = $model->countFilteredData($searchValue);

            // Prepare response for DataTables
            $response = [
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data
            ];

            // Return JSON response
            return $this->response->setJSON($response);
        }

        // Load the view for non-AJAX requests
        return view('careerGuidence/view');
    }

    public function careerGuidenceView($id)
    {

        $model = new DashboardModel();
        $singleData = $model->careerGuidenceSingleData($id);

        $data['career'] = $singleData;

        return view('careerGuidence/singleView', $data);
    }

    public function externalRecords()
    {
        $model = new DashboardModel();

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);

            $query = "SELECT 
                        c.name as course_name,
                        o.name as org_name,
                        u.name,
                        u.email,
                        u.mobile,
                        e.*
                    FROM 
                        tbl_external_records e
                    JOIN tbl_organizations_course oc ON oc.id = e.organization_course_id
                    JOIN tbl_courses c ON c.id = oc.course_id
                    JOIN tbl_organizations o ON o.id = oc.organization_id
                    JOIN tbl_users u ON u.id = e.user_id
                    WHERE 1 ";

            if (!empty($searchValue)) {
                $like = " LIKE '%" . $searchValue . "%'";
                $query .= " AND (
                    u.name $like
                    OR u.email $like
                    OR u.mobile $like
                    OR o.name $like
                    OR c.name $like
                ) ";
            }

            $query .= ' ORDER BY id DESC';


            $totalRecords = count($model->getExternalRecords($query));

            if ($length != -1) {
                $query .= ' LIMIT ' . $start . ', ' . $length;
            }

            $result = $model->getExternalRecords($query);
            $data = array();
            $i = $start + 1;

            if (!empty($result)) {
                foreach ($result as $row) {
                    $date = new DateTime($row->created_at);
                    $formattedDate = $date->format('d-m-Y');

                    $data[] = [
                        $i,
                        $row->name,
                        $row->email,
                        $row->mobile,
                        $row->org_name,
                        $row->course_name,
                        $formattedDate
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
        return view('external_records/view');
    }

    public function walletHistory()
    {
        $model = new UserModel();

        if ($this->request->isAJAX()) {

            $start = intval($this->request->getGet('start')) ?? 0;
            $length = intval($this->request->getGet('length')) ?? 10;
            $searchValue = $this->request->getGet('search')['value'];
            $searchValue = filter_var($searchValue, FILTER_SANITIZE_STRING);

            $txn_type = $this->request->getGet('columns')[1]['search']['value'];
            $from_date = $this->request->getGet('columns')[2]['search']['value'];
            $to_date = $this->request->getGet('columns')[3]['search']['value'];

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
                    WHERE 1 ";

            if ($txn_type != NULL && $txn_type != '') {
                $query .= "  AND w.txn_type = '$txn_type' ";
            }

            if ($from_date != '' && $from_date != NULL && $to_date != '' && $to_date != NULL) {
                $query .= " AND w.txn_date BETWEEN '$from_date' AND '$to_date'";
            }

            if (!empty($searchValue)) {
                $like = " LIKE '%" . htmlspecialchars($searchValue) . "%'";
                $query .= " AND (
                    u.name $like
                    OR u.email $like
                    OR u.mobile $like
                    OR w.ref_number $like
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
        
        return view('wallet_history');
    }
}
