<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AdminModel;
use App\Models\ActivityModel;

class Login extends BaseController
{
    /**
     * Resources
     * 001. Client Login
     * 002. Check Client Login
     * 003. Client Logout
     * 004. Admin Login
     * 005. Check Admin Login
     * 006. Admin Logout
     */
    /* 001. Client Login */

    public function index()
    {
        $locked = $this->session->get('locked');
        if ($locked) {
            $activity_model = new ActivityModel();

            $activity = array();
            $activity['activity_type'] = 'error';
            $activity['activity_name'] = 'Unauthorized Access';
            $activity['ip_address'] = getUserIpAddr();
            $activity['visitor_country'] = ip_info('Visitor', 'Country');
            $activity['visitor_state'] = ip_info('Visitor', 'State');
            $activity['visitor_city'] = ip_info('Visitor', 'City');
            $activity['visitor_address'] = ip_info('Visitor', 'Address');
            $activity['create_time'] = current_time();
            $activity['create_date'] = current_date();

            try {
                $activity_model->insert($activity);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $message = 'A person is trying to access out system: IP- ' . $activity['ip_address'] . '. Country- ' . $activity['visitor_country'] . '. Time- ' . $activity['create_time'] . '. Date- ' . $activity['create_date'];

            $email = \Config\Services::email();
            $email->setFrom($this->data['settings']['admin_email'], $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject('Unauthorized Access - ' . $this->data['settings']['project_name']);
            $email->setMessage($message);
            $email->send();

            $difference = time() - $locked;
            if ($difference > 3000) {
                $this->session->remove('locked');
                $this->session->remove('login_attempt');
            }
        }
        $data = array();
        $data['title'] = 'Login';
        $data['locked'] = $locked;
        return view('website/login', $data);
    }

    /* 002. Client Client Login */

    public function auth()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please Enter Your Email.',
                    'valid_email' => 'Please Check The Email Field. It Does Not Appear To Be Valid.'
                ]
            ],
            'password' => [
                'label' => 'Your Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Password.'
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $user_model = new UserModel();
            $activity_model = new ActivityModel();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $data = $user_model->where('user_email', $email)->where('user_status', 'active')->first();

            if ($data) {
                $database_password = $data['user_password'];
                if ($password == $database_password) {
                    $sdata = [
                        'user_id' => $data['user_id'],
                        'user_name' => $data['user_name'],
                        'logged_in' => TRUE
                    ];
                    $this->session->set($sdata);

                    $activity = array();
                    $activity['fk_user_id'] = $sdata['user_id'];
                    $activity['activity_type'] = 'success';
                    $activity['activity_name'] = $sdata['user_name'] . ' Login Success';

                    $activity['ip_address'] = getUserIpAddr();
                    $activity['visitor_country'] = ip_info('Visitor', 'Country');
                    $activity['visitor_state'] = ip_info('Visitor', 'State');
                    $activity['visitor_city'] = ip_info('Visitor', 'City');
                    $activity['visitor_address'] = ip_info('Visitor', 'Address');

                    $activity['create_time'] = current_time();
                    $activity['create_date'] = current_date();
                    $activity['created_by'] = $sdata['user_id'];

                    try {
                        $activity_model->insert($activity);
                    } catch (\Exception $e) {
                        die($e->getMessage());
                    }

                    echo 'success';
                    exit();
                } else {
                    $login_attempt = session()->get('login_attempt');
                    $sdata = array();
                    $sdata['login_attempt'] = $login_attempt + 1;
                    $this->session->set($sdata);
                    if ($login_attempt > 2) {
                        $sdata = array();
                        $sdata['locked'] = time();
                        $this->session->set($sdata);
                        echo 'locked';
                        exit();
                    }

                    $activity = array();
                    $activity['activity_type'] = 'warning';
                    $activity['activity_name'] = 'User Login Failed - Wrong Password -' . $password;
                    $activity['ip_address'] = getUserIpAddr();
                    $activity['visitor_country'] = ip_info('Visitor', 'Country');
                    $activity['visitor_state'] = ip_info('Visitor', 'State');
                    $activity['visitor_city'] = ip_info('Visitor', 'City');
                    $activity['visitor_address'] = ip_info('Visitor', 'Address');
                    $activity['create_time'] = current_time();
                    $activity['create_date'] = current_date();

                    try {
                        $activity_model->insert($activity);
                    } catch (\Exception $e) {
                        die($e->getMessage());
                    }

                    echo 'Wrong Password';
                    exit();
                }
            } else {
                $login_attempt = session()->get('login_attempt');
                $sdata = array();
                $sdata['login_attempt'] = $login_attempt + 1;
                $this->session->set($sdata);
                if ($login_attempt > 2) {
                    $sdata = array();
                    $sdata['locked'] = time();
                    $this->session->set($sdata);
                    echo 'locked';
                    exit();
                }

                $activity = array();
                $activity['activity_type'] = 'warning';
                $activity['activity_name'] = 'User Login Failed - User Not Found -' . $email;
                $activity['ip_address'] = getUserIpAddr();
                $activity['visitor_country'] = ip_info('Visitor', 'Country');
                $activity['visitor_state'] = ip_info('Visitor', 'State');
                $activity['visitor_city'] = ip_info('Visitor', 'City');
                $activity['visitor_address'] = ip_info('Visitor', 'Address');
                $activity['create_time'] = current_time();
                $activity['create_date'] = current_date();

                try {
                    $activity_model->insert($activity);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                echo 'User Not Found';
                exit();
            }
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    /* 003. Client Logout */

    public function logout()
    {
        $activity_model = new ActivityModel();

        $activity = array();
        $activity['fk_user_id'] = $this->session->get('user_id');
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'User Logout';
        $activity['ip_address'] = getUserIpAddr();
        $activity['visitor_country'] = ip_info('Visitor', 'Country');
        $activity['visitor_state'] = ip_info('Visitor', 'State');
        $activity['visitor_city'] = ip_info('Visitor', 'City');
        $activity['visitor_address'] = ip_info('Visitor', 'Address');
        $activity['create_time'] = current_time();
        $activity['create_date'] = current_date();
        $activity['created_by'] = $this->session->get('user_id');

        try {
            $activity_model->insert($activity);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $sdata = [
            'user_id' => '',
            'user_name' => '',
            'logged_in' => FALSE
        ];

        $this->session->set($sdata);
        return redirect()->to('/login')->with('warning', 'Client Logout Successful');
    }

    /* 004. Admin Login */

    public function admin_login()
    {
        $locked = $this->session->get('locked');
        if ($locked) {
            $activity_model = new ActivityModel();

            $activity = array();
            $activity['activity_type'] = 'error';
            $activity['activity_name'] = 'Unauthorized Access';
            $activity['ip_address'] = getUserIpAddr();
            $activity['visitor_country'] = ip_info('Visitor', 'Country');
            $activity['visitor_state'] = ip_info('Visitor', 'State');
            $activity['visitor_city'] = ip_info('Visitor', 'City');
            $activity['visitor_address'] = ip_info('Visitor', 'Address');
            $activity['create_time'] = current_time();
            $activity['create_date'] = current_date();

            try {
                $activity_model->insert($activity);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $message = 'A person is trying to access out system: IP- ' . $activity['ip_address'] . '. Country- ' . $activity['visitor_country'] . '. Time- ' . $activity['create_time'] . '. Date- ' . $activity['create_date'];

            $email = \Config\Services::email();
            $email->setFrom($this->data['settings']['admin_email'], $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject('Unauthorized Access - ' . $this->data['settings']['project_name']);
            $email->setMessage($message);
            $email->send();

            $difference = time() - $locked;
            if ($difference > 3) {
                $this->session->remove('locked');
                $this->session->remove('login_attempt');
            }
        }
        $data = array();
        $data['title'] = 'Login';
        $data['locked'] = $locked;
        return view('dashboard/login', $data);
    }

    /* 005. Check Admin Login */

    public function admin_auth()
    {
        helper(['form']);

        $validation = \Config\Services::validation();
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Please Enter Your Email.',
                    'valid_email' => 'Please Check The Email Field. It Does Not Appear To Be Valid.'
                ]
            ],
            'password' => [
                'label' => 'Your Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Password.'
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $admin_model = new AdminModel();
            $activity_model = new ActivityModel();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $admin_info = $admin_model->where('admin_email', $email)->where('admin_status', 'active')->first();

            if ($admin_info) {

                $database_password = $admin_info['admin_password'];
                if ($password == $database_password) {

                    $role_relation = $admin_model->query("SELECT fk_role_id FROM role_relation WHERE fk_role_id = '" . $admin_info['admin_id'] . "'")->getRowArray()['fk_role_id'];
                    $role_name = $admin_model->query("SELECT role_name FROM roles WHERE role_id = '$role_relation'")->getRowArray()['role_name'];

                    $unseen_notifications = $admin_model->query("SELECT * FROM notifications WHERE view_status = 'unseen' ORDER BY notification_id DESC")->getResultArray();
                    $total_notifications = $admin_model->query("SELECT COUNT(notification_id) AS total_notification FROM notifications WHERE view_status = 'unseen'")->getRowArray()['total_notification'];

                    if ($role_name == 'superadmin') :

                        $sdata = [
                            'admin_id' => $admin_info['admin_id'],
                            'user_name' => $admin_info['user_name'],
                            'admin_image' => $admin_info['admin_image'],
                            'notifications' => $unseen_notifications,
                            'total_notifications' => $total_notifications,
                            'permissions' => 'superadmin',
                            'logged_in' => TRUE
                        ];
                        $this->session->set($sdata);

                        $activity = array();
                        $activity['fk_admin_id'] = $sdata['admin_id'];
                        $activity['activity_type'] = 'success';
                        $activity['activity_name'] = $sdata['user_name'] . ' Login Success';

                        $activity['ip_address'] = getUserIpAddr();
                        $activity['visitor_country'] = ip_info('Visitor', 'Country');
                        $activity['visitor_state'] = ip_info('Visitor', 'State');
                        $activity['visitor_city'] = ip_info('Visitor', 'City');
                        $activity['visitor_address'] = ip_info('Visitor', 'Address');

                        $activity['create_time'] = current_time();
                        $activity['create_date'] = current_date();
                        $activity['created_by'] = $sdata['admin_id'];

                        try {
                            $activity_model->insert($activity);
                        } catch (\Exception $e) {
                            die($e->getMessage());
                        }

                        echo 'success';
                        exit();
                    else :
                        $all_permissions = $admin_model->query("SELECT permission_name FROM permissions WHERE fk_role_id = '" . $admin_info['admin_id'] . "'")->getResultArray();

                        $i = 1;
                        foreach ($all_permissions as $value) {
                            $permissions[$i] = $value['permission_name'];
                            $i++;
                        }
                        $permissions;

                        $sdata = [
                            'admin_id' => $admin_info['admin_id'],
                            'user_name' => $admin_info['user_name'],
                            'admin_image' => $admin_info['admin_image'],
                            'notifications' => $unseen_notifications,
                            'total_notifications' => $total_notifications,
                            'permissions' => $permissions,
                            'logged_in' => TRUE
                        ];
                        $this->session->set($sdata);

                        $activity = array();
                        $activity['fk_admin_id'] = $sdata['admin_id'];
                        $activity['activity_type'] = 'success';
                        $activity['activity_name'] = $sdata['user_name'] . ' Login Success';

                        $activity['ip_address'] = getUserIpAddr();
                        $activity['visitor_country'] = ip_info('Visitor', 'Country');
                        $activity['visitor_state'] = ip_info('Visitor', 'State');
                        $activity['visitor_city'] = ip_info('Visitor', 'City');
                        $activity['visitor_address'] = ip_info('Visitor', 'Address');

                        $activity['create_time'] = current_time();
                        $activity['create_date'] = current_date();
                        $activity['created_by'] = $sdata['admin_id'];

                        try {
                            $activity_model->insert($activity);
                        } catch (\Exception $e) {
                            die($e->getMessage());
                        }

                        echo 'success';
                        exit();
                    endif;
                } else {
                    $login_attempt = session()->get('login_attempt');
                    $sdata = array();
                    $sdata['login_attempt'] = $login_attempt + 1;
                    $this->session->set($sdata);
                    if ($login_attempt > 2) {
                        $sdata = array();
                        $sdata['locked'] = time();
                        $this->session->set($sdata);
                        echo 'locked';
                        exit();
                    }

                    $activity = array();
                    $activity['activity_type'] = 'warning';
                    $activity['activity_name'] = 'Admin Login Failed - Wrong Password -' . $password;
                    $activity['ip_address'] = getUserIpAddr();
                    $activity['visitor_country'] = ip_info('Visitor', 'Country');
                    $activity['visitor_state'] = ip_info('Visitor', 'State');
                    $activity['visitor_city'] = ip_info('Visitor', 'City');
                    $activity['visitor_address'] = ip_info('Visitor', 'Address');
                    $activity['create_time'] = current_time();
                    $activity['create_date'] = current_date();

                    try {
                        $activity_model->insert($activity);
                    } catch (\Exception $e) {
                        die($e->getMessage());
                    }

                    echo 'Wrong Password';
                    exit();
                }
            } else {
                $login_attempt = session()->get('login_attempt');
                $sdata = array();
                $sdata['login_attempt'] = $login_attempt + 1;
                $this->session->set($sdata);
                if ($login_attempt > 2) {
                    $sdata = array();
                    $sdata['locked'] = time();
                    $this->session->set($sdata);
                    echo 'locked';
                    exit();
                }

                $activity = array();
                $activity['activity_type'] = 'warning';
                $activity['activity_name'] = 'Admin Login Failed - User Not Found -' . $email;
                $activity['ip_address'] = getUserIpAddr();
                $activity['visitor_country'] = ip_info('Visitor', 'Country');
                $activity['visitor_state'] = ip_info('Visitor', 'State');
                $activity['visitor_city'] = ip_info('Visitor', 'City');
                $activity['visitor_address'] = ip_info('Visitor', 'Address');
                $activity['create_time'] = current_time();
                $activity['create_date'] = current_date();

                try {
                    $activity_model->insert($activity);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }

                echo 'Admin Not Found';
                exit();
            }
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    /* 006. Admin Logout */

    public function admin_logout()
    {
        $activity_model = new ActivityModel();

        $activity = array();
        $activity['fk_admin_id'] = $this->session->get('admin_id');
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'Admin Logout';
        $activity['ip_address'] = getUserIpAddr();
        $activity['visitor_country'] = ip_info('Visitor', 'Country');
        $activity['visitor_state'] = ip_info('Visitor', 'State');
        $activity['visitor_city'] = ip_info('Visitor', 'City');
        $activity['visitor_address'] = ip_info('Visitor', 'Address');
        $activity['create_time'] = current_time();
        $activity['create_date'] = current_date();
        $activity['created_by'] = $this->session->get('admin_id');

        try {
            $activity_model->insert($activity);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $sdata = [
            'admin_id' => '',
            'user_name' => '',
            'admin_image' => '',
            'notifications' => '',
            'total_notifications' => '',
            'permissions' => '',
            'logged_in' => FALSE
        ];
        $this->session->set($sdata);

        return redirect()->to('/admin-login')->with('warning', 'Admin Logout Successful');
    }
}
