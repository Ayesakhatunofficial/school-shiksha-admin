<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\NotificationModel;
use App\Models\UserModel;

class NotificationController extends BaseController
{
    protected $NotificationModel;
    protected $UserModel;

    public function __construct()
    {
        // Load NotificationModel using dependency injection
        $this->NotificationModel = new NotificationModel();
        $this->UserModel = new UserModel();
    }
    public function notification()
    {
        $data['notify'] = $this->NotificationModel->table('tbl_notifications')
            ->join('tbl_users', 'tbl_users.id = tbl_notifications.user_id', 'inner')
            ->select('tbl_users.id AS users_id, tbl_users.name as users_name ,tbl_notifications.id, tbl_notifications.subject,tbl_notifications.message')
            ->orderBy('tbl_notifications.id', 'DESC')
            ->groupBy('tbl_notifications.user_id')
            ->get()
            ->getResultArray();

        return view(
            'notification/view',
            $data
        );
    }


    public function addNotification()
    {
        $data['roles'] = $this->NotificationModel->getRoles();

        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getVar();

            if ($data['class'] != '') {
                $class_id = $data['class'];
                $students = $this->NotificationModel->getStudents($class_id);

                if ($students) {
                    foreach ($students as $user) {
                        $notificationData = [
                            'user_id' => $user->user_id,
                            'subject' => $data['subject'],
                            'message' => $data['message'],
                        ];
                        if (!$this->NotificationModel->insert($notificationData)) {
                            return redirect()->back()->with('error', 'Failed to insert notification!');
                        }
                    }
                }
            } else {

                foreach ($data['user_id'] as $key => $user_id) {
                    $notificationData = [
                        'user_id' => $user_id,
                        'subject' => $data['subject'],
                        'message' => $data['message'],
                    ];
                    if (!$this->NotificationModel->insert($notificationData)) {
                        return redirect()->back()->with('error', 'Failed to insert notification!');
                    }
                }
            }
            return redirect()->to('notification')->with('msg', 'Notifications inserted successfully!');
        }

        return view('notification/add', $data);
    }


    public function fetchUser()
    {
        $id = $this->request->getPost('role_id');
        $userid = $this->request->getPost('userid');

        $result = $this->UserModel->where('role_id', $id)->get()->getResultArray();

        $options = '<option value="">--Select--</option>';

        if ($result) {
            foreach ($result as $row) {
                $selected = $row['id'] == $userid ? 'selected' : '';
                $options .= '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['name'] . '</option>';
            }
        }

        return $this->response->setBody($options);
    }

    public function getClass()
    {
        $model = new NotificationModel();
        $result = $model->getClass();
        return $this->response->setJSON($result);

    }

    public function fetchNotification($id = NULL)
    {
        $data['notify'] = $this->NotificationModel->where('user_id', $id)->find();
        return view('notification/notification_view', $data);
    }

    public function readNotification()
    {
        $id = $this->request->getPost('userId');
        $updated = $this->NotificationModel->where('user_id', $id)->set(['is_read' => '1'])->update();
        $error = 'update notification';
        if (!$updated) {
            return $error = 'Failed to update notification!';
        }
        return $error;
    }

    public function editNotification($id)
    {
        $model = new NotificationModel();
        $data['roles'] = $model->getRoles();
        $data['notification'] = $model->getNotificationById($id);

        return view('notification/edit', $data);
    }



    public function updateNotification($id = NULL)
    {

        $data['roles'] = $this->NotificationModel->getRoles();

        if ($this->request->getVar()) {
            $data = $this->request->getVar();

            foreach ($data['user_id'] as $key => $user_id) {
                $notificationData = [
                    'user_id' => $user_id,
                    'subject' => $data['subject'],
                    'message' => $data['message'],
                ];
                if (!$this->NotificationModel->update($id, $notificationData)) {
                    return redirect()->back()->with('error', 'Failed to edit notification!');
                }
            }
            return redirect()->to('notification')->with('msg', 'Notifications updated successfully!');
        }

        return view('notification/edit', $data);
    }
}
