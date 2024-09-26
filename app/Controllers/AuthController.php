<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\UserModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class AuthController extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()
                ->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new AuthModel();

        $username = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->auth($username);


        if (!is_null($data)) {
            if ($data->password == md5($password)) {

                $session_data = [
                    'user' => $data,
                    'isLoggedIn' => TRUE,
                    $session->set('logo', getsetting('company_logo'))
                ];
                $session->set($session_data);

                return redirect('dashboard');
            } else {
                // $session->setFlashdata('pass_error', 'Invalid Password');
                return redirect('/')
                    ->withInput('post', $this->request->getPost()) // Keep the input values
                    ->with('pass_error', 'Invalid Password');
            }
        } else {
            return redirect('/')
                ->withInput('post', $this->request->getPost()) // Keep the input values
                ->with('name_error', 'Invalid Username');
        }
    }

    public function logout()
    {
        session()->remove('isLoggedIn');
        session()->remove('user');
        return redirect()
            ->to('/');
    }

    public function forgetPassword()
    {
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email' => [
                    'label' => 'Email',
                    'rules' => [
                        'required', 'valid_email',
                        static function ($value, $data, &$error) {
                            $db = db_connect();
                            $result = $db->table('tbl_users')
                                ->where('email', $value)
                                ->get()
                                ->getRow();

                            if (is_null($result)) {
                                $error = $value . ' does not exists';
                                return false;
                            }

                            return true;
                        }
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput();
            }

            $email = $this->request->getVar('email');

            $model = new AuthModel();
            $user = $model->auth($email);

            $token = sha1(uniqid(mt_rand(), true));
            $reset_link = base_url('reset-password') . '?token=' . $token;

            $token_data = [
                'reset_token' => $token,
                'otp_valid_till' => date('Y-m-d H:i:s', time() + (15 * 60))
            ];

            if ($model->updateData($token_data, $email)) {
                $mail = new PHPMailer(true);

                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->isSMTP();
                $mail->Host       = getsetting('smtp_host');
                $mail->SMTPAuth   = true;
                $mail->Username   = getsetting('smtp_username');
                $mail->Password   = getsetting('smtp_pass');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = getsetting('smtp_port');

                $mail->setFrom('noreply@ehostingguru.com', getsetting('company_name'));
                $mail->addAddress($email, $user->name);

                $mail->isHTML(true);
                $mail->Subject = 'Reset Your Password';
                $mail->Body    = "<p>Dear " . $user->name . ",</p>
                            <p>We received a request to reset the password for your account. To proceed with the password reset, please click on the link below:</p>
                            <p><a href='" . $reset_link . "'>" . $reset_link . "</a></p>
                            <p>If you did not request this password reset, you can safely ignore this email. Your password will remain unchanged and the link is valid for 15 min.</p>
                            <p>Thank you,<br>" . getsetting('company_name') . "</p>";

                if ($mail->send()) {
                    return redirect()->back()->with('msg', 'We\'ve sent you an email containing further instructions for resetting your password.');
                } else {
                    return redirect()->back()->with('error', 'Something went wrong!');
                }
            }
        }
        return view('auth/forget_password');
    }

    public function resetPassword()
    {
        $session = session();
        $model = new AuthModel();
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'new_password' => [
                    'label' => 'New Password',
                    'rules' => 'required'
                ],
                'confirm_password' => [
                    'label' => 'Confirm Password',
                    'rules' => 'required|matches[new_password]'
                ]
            ];
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput();
            }

            $input = $this->request->getVar();

            $result = $model->updatePassword($input);

            if ($result) {
                return redirect()->to('forget-password')->with('msg', 'Password reset successfully!');
            } else {
                return redirect()->to('forget-password')->with('error', 'Something went wrong!');
            }
        }
        $token = $this->request->getVar('token');
        $data = [];
        if ($token != '' && $token != NULL) {
            $verify_token = $model->verifyToken($token);
            if ($verify_token) {

                $valid_time = $verify_token->otp_valid_till;
                $current_time = date('Y-m-d H:i:s');

                if ($current_time >= $valid_time) {
                    return redirect()->to('forget-password')->with('error', 'Time expired.');
                } else {
                    $data['email'] = $verify_token->email;
                    $session->set($data);
                    return view('auth/reset_password');
                }
            } else {
                return redirect()->to('forget-password')->with('error', 'Invalid token.');
            }
        } else {
            return redirect()->to('forget-password')->with('error', 'Access token is empty');
        }
    }
}
