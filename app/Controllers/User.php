<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserMetaModel;
use App\Models\ActivityModel;
use App\Models\BalanceModel;
use App\Models\TransactionModel;
use App\Models\CashbookModel;

class User extends BaseController {
    /**
     * Resources
     * 001. Users
     * 002. User Fund
     */
    /* 001. Users */

    public function index() {
        $permission_status = $this->check_permission('view_user');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Users';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('user/users', $data);
        return view('dashboard/master', $data);
    }

    public function user_datatable() {
        $permission_status = $this->check_permission('view_user');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();
        $users = $user_model->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($users as $r) {
            if ($r['user_image']):
                $profile_image = '<img src="' . base_url() . '/uploads/profile_image/' . $r['user_image'] . '" class="img-thumbnail" />';
            else:
                $profile_image = '<img src="' . base_url() . '/assets/backend/img/default/user.png" class="img-thumbnail" />';
            endif;
            $data[] = array(
                $r['user_id'],
                $profile_image,
                $r['first_name'],
                $r['last_name'],
                $r['user_name'],
                $r['user_email'],
                $r['user_mobile'],
                ucfirst($r['user_status']),
                $r['user_address'],
                date($settings['date_format'], strtotime($r['create_date'])),
                '<div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                        <a class="dropdown-item" href="' . base_url() . '/user/edit_user/' . $r['user_id'] . '">Edit</a>
                        <a class="dropdown-item" href="' . base_url() . '/user/delete_user/' . $r['user_id'] . '">Delete</a>
                    </div>
                </div>'
            );
        }
        $result = array(
            "recordsTotal" => $user_model->countAll(),
            "recordsFiltered" => $user_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function add_user() {
        $permission_status = $this->check_permission('add_user');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Add User';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('user/add_user', $data);
        return view('dashboard/master', $data);
    }

    public function save_user() {
        $permission_status = $this->check_permission('add_user');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();
        $usermeta_model = new UserMetaModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');

        $data = array();
        $data['first_name'] = $this->request->getPost('first_name');
        $data['user_name'] = $this->request->getPost('user_name');
        $data['user_password'] = $this->request->getPost('user_password');
        $data['user_sex'] = $this->request->getPost('sex');
        if ($this->request->getFile('image')):
            $img = $this->request->getFile('image');
            $img->move(WRITEPATH . '../public/uploads/profile_image/');
            $data['user_image'] = $img->getName();
        endif;
        $data['last_name'] = $this->request->getPost('last_name');
        $data['user_mobile'] = $this->request->getPost('user_mobile');
        $data['user_email'] = $this->request->getPost('user_email');
        $data['user_address'] = $this->request->getPost('user_address');
        $data['user_status'] = $this->request->getPost('status');
        $data['create_time'] = current_time();
        $data['create_date'] = current_date();
        $data['created_by'] = $admin_id;

        try {
            $user_model->save($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $fk_user_id = $user_model->getInsertID();

        foreach ($this->request->getPost('meta') as $key => $value) {
            $meta = array();
            $meta['fk_user_id'] = $fk_user_id;
            $meta['meta_key'] = $key;
            $meta['meta_value'] = $value;
            try {
                $usermeta_model->insert($meta);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        if ($this->request->getPost('more')):
            foreach ($this->request->getPost('more') as $key => $value) {
                $meta = array();
                $meta['fk_user_id'] = $fk_user_id;
                $meta['meta_key'] = $key;
                $meta['meta_value'] = $value;
                try {
                    $usermeta_model->insert($meta);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }
            }
        endif;

        if ($this->request->getPost('file_name')):
            $meta = array();
            $meta['fk_user_id'] = $fk_user_id;
            $meta['meta_key'] = 'file_name';
            $meta['meta_value'] = $this->request->getPost('file_name');
            try {
                $usermeta_model->insert($meta);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $upload_file = $this->request->getFile('file_upload');
            $upload_file->move(WRITEPATH . '../public/uploads/user_file/');
            $file_name = $upload_file->getName();

            $file = array();
            $file['fk_user_id'] = $fk_user_id;
            $file['meta_key'] = 'file_upload';
            $file['meta_value'] = $file_name;
            try {
                $usermeta_model->insert($file);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        endif;

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'New User Created - ' . $fk_user_id;
        $activity['ip_address'] = getUserIpAddr();
        $activity['visitor_country'] = ip_info('Visitor', 'Country');
        $activity['visitor_state'] = ip_info('Visitor', 'State');
        $activity['visitor_city'] = ip_info('Visitor', 'City');
        $activity['visitor_address'] = ip_info('Visitor', 'Address');
        $activity['create_time'] = current_time();
        $activity['create_date'] = current_date();
        $activity['created_by'] = $admin_id;

        try {
            $activity_model->insert($activity);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert End */

        echo "<div class='alert alert-success'>New User Created</div>";
        exit();
    }

    public function edit_user($user_id) {
        $permission_status = $this->check_permission('edit_user');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();
        $usermeta_model = new UserMetaModel();

        $data = array();
        $data['title'] = 'Edit The User';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['user_info'] = $user_model->where('user_id', $user_id)->first();
        $meta = $usermeta_model->select('meta_key, meta_value')->where('fk_user_id', $user_id)->find();
        if ($meta) :
            foreach ($meta as $eachMeta) :
                $data['user_info']['meta'][$eachMeta['meta_key']] = $eachMeta['meta_value'];
            endforeach;
        endif;

        $data['additional_file_name'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'file_name')->find();
        $data['additional_file_upload'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'file_upload')->find();

        $data['additional_email_owner'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'email_owner')->find();
        $data['additional_email_address'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'email_address')->find();

        $data['additional_mobile_owner'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'mobile_owner')->find();
        $data['additional_mobile_number'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'mobile_number')->find();

        $data['additional_address_type'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'address_type')->find();
        $data['additional_address_name'] = $usermeta_model->where('fk_user_id', $user_id)->where('meta_key', 'address_name')->find();

        $data['home'] = view('user/edit_user', $data);
        return view('dashboard/master', $data);
    }

    public function update_user() {
        $permission_status = $this->check_permission('edit_user');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();
        $usermeta_model = new UserMetaModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $user_id = $this->request->getPost('user_id');

        $data = array();
        $data['first_name'] = $this->request->getPost('first_name');
        $data['user_name'] = $this->request->getPost('user_name');
        $data['user_password'] = $this->request->getPost('user_password');
        $data['user_sex'] = $this->request->getPost('sex');
        if ($this->request->getFile('image')):
            @unlink('../public/uploads/profile_image/' . $this->request->getPost('previous_image'));
            $img = $this->request->getFile('image');
            $img->move(WRITEPATH . '../public/uploads/profile_image/');
            $data['user_image'] = $img->getName();
        else:
            /* If User Does Not Change Image */
            $data['user_image'] = $this->request->getPost('previous_image');
        endif;
        $data['last_name'] = $this->request->getPost('last_name');
        $data['user_mobile'] = $this->request->getPost('user_mobile');
        $data['user_email'] = $this->request->getPost('user_email');
        $data['user_address'] = $this->request->getPost('user_address');
        $data['user_status'] = $this->request->getPost('status');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $user_model
                    ->where('user_id', $user_id)
                    ->set($data)
                    ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        foreach ($this->request->getPost('meta') as $key => $value) {
            $meta = array();
            $meta['fk_user_id'] = $user_id;
            $meta['meta_key'] = $key;
            $meta['meta_value'] = $value;
            try {
                $usermeta_model
                        ->where('meta_key', $key)
                        ->where('fk_user_id', $user_id)
                        ->set($meta)
                        ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        if ($this->request->getPost('more')):
            foreach ($this->request->getPost('more') as $key => $value) {
                $meta = array();
                $meta['fk_user_id'] = $user_id;
                $meta['meta_key'] = $key;
                $meta['meta_value'] = $value;
                try {
                    $usermeta_model->insert($meta);
                } catch (\Exception $e) {
                    die($e->getMessage());
                }
            }
        endif;

        if ($this->request->getPost('file_name')):
            $meta = array();
            $meta['fk_user_id'] = $user_id;
            $meta['meta_key'] = 'file_name';
            $meta['meta_value'] = $this->request->getPost('file_name');
            try {
                $usermeta_model->insert($meta);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $upload_file = $this->request->getFile('file_upload');
            $upload_file->move(WRITEPATH . '../public/uploads/user_file/');
            $file_name = $upload_file->getName();

            $file = array();
            $file['fk_user_id'] = $user_id;
            $file['meta_key'] = 'file_upload';
            $file['meta_value'] = $file_name;

            try {
                $usermeta_model->insert($file);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        endif;

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'User Updated - ' . $user_id;
        $activity['ip_address'] = getUserIpAddr();
        $activity['visitor_country'] = ip_info('Visitor', 'Country');
        $activity['visitor_state'] = ip_info('Visitor', 'State');
        $activity['visitor_city'] = ip_info('Visitor', 'City');
        $activity['visitor_address'] = ip_info('Visitor', 'Address');
        $activity['create_time'] = current_time();
        $activity['create_date'] = current_date();
        $activity['created_by'] = $admin_id;

        try {
            $activity_model->insert($activity);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert End */

        echo "<div class='alert alert-success'>User Updated</div>";
        exit();
    }

    /* 002. User Fund */

    public function add_fund() {
        $permission_status = $this->check_permission('add_fund');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();

        $data = array();
        $data['title'] = 'Add Fund';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_users'] = $user_model->where('user_status', 'active')->find();
        $data['home'] = view('user/add_fund', $data);
        return view('dashboard/master', $data);
    }

    public function findCustomerBalance($customer_id) {
        $permission_status = $this->check_permission('add_fund');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $balance_model = new BalanceModel();
        $balance = $balance_model->where('fk_user_id', $customer_id)->first();

        if ($balance):
            echo $balance['balance_amount'];
            exit();
        else:
            echo 0;
            exit();
        endif;
    }

    public function save_fund() {
        $permission_status = $this->check_permission('add_fund');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $balance_model = new BalanceModel();
        $transaction_model = new TransactionModel();
        $cashbook_model = new CashbookModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $customer_id = $this->request->getPost('user_id');
        $add_fund = $this->request->getPost('add_fund');
        $transaction_date = $this->request->getPost('transaction_date');

        $balance = $balance_model->where('fk_user_id', $customer_id)->first();
        if ($balance):
            $data = array();
            $data['fk_user_id'] = $customer_id;
            $data['balance_amount'] = $balance['balance_amount'] + $add_fund;
            $data['modify_time'] = current_time();
            $data['modify_date'] = current_date();
            $data['modified_by'] = $admin_id;

            try {
                $balance_model
                        ->where('fk_user_id', $customer_id)
                        ->set($data)
                        ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Transaction Insert Start */

            $transaction = array();
            $transaction['transaction_date'] = $transaction_date;
            $transaction['transaction_type'] = 'user_fund';
            $transaction['fk_reference_id'] = $customer_id;
            $transaction['transaction_amount'] = $add_fund;
            $transaction['paid_amount'] = $add_fund;
            $transaction['due_amount'] = 0;
            $transaction['create_time'] = current_time();
            $transaction['create_date'] = current_date();
            $transaction['created_by'] = $admin_id;

            try {
                $transaction_model->insert($transaction);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Transaction Insert End */

            /* Cashbook Insert Start */

            $cashbook = array();
            $cashbook['table_name'] = 'balances';
            $cashbook['fk_reference_id'] = $customer_id;
            $cashbook['cashbook_description'] = 'User Balance';
            $cashbook['in_amount'] = $add_fund;
            $cashbook['create_time'] = current_time();
            $cashbook['create_date'] = current_date();
            $cashbook['created_by'] = $admin_id;

            try {
                $cashbook_model->insert($cashbook);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Cashbook Insert End */

            /* Activity Insert Start */

            $activity = array();
            $activity['fk_user_id'] = $admin_id;
            $activity['activity_type'] = 'success';
            $activity['activity_name'] = 'Fund Updated - ' . $customer_id;
            $activity['ip_address'] = getUserIpAddr();
            $activity['visitor_country'] = ip_info('Visitor', 'Country');
            $activity['visitor_state'] = ip_info('Visitor', 'State');
            $activity['visitor_city'] = ip_info('Visitor', 'City');
            $activity['visitor_address'] = ip_info('Visitor', 'Address');
            $activity['create_time'] = current_time();
            $activity['create_date'] = current_date();
            $activity['created_by'] = $admin_id;

            try {
                $activity_model->insert($activity);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Activity Insert End */

            echo 'success';
            exit();
        else:
            $data = array();
            $data['fk_user_id'] = $customer_id;
            $data['balance_amount'] = $add_fund;
            $data['create_time'] = current_time();
            $data['create_date'] = current_date();
            $data['created_by'] = $admin_id;

            try {
                $balance_model->insert($data);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Transaction Insert Start */

            $transaction = array();
            $transaction['transaction_date'] = $transaction_date;
            $transaction['fk_reference_id'] = $customer_id;
            $transaction['transaction_amount'] = $add_fund;
            $transaction['paid_amount'] = $add_fund;
            $transaction['due_amount'] = 0;
            $transaction['create_time'] = current_time();
            $transaction['create_date'] = current_date();
            $transaction['created_by'] = $admin_id;
            try {
                $transaction_model->insert($transaction);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Transaction Insert End */

            /* Cashbook Insert Start */

            $cashbook = array();
            $cashbook['table_name'] = 'balances';
            $cashbook['fk_reference_id'] = $customer_id;
            $cashbook['cashbook_description'] = 'User Balance';
            $cashbook['in_amount'] = $add_fund;
            $cashbook['create_time'] = current_time();
            $cashbook['create_date'] = current_date();
            $cashbook['created_by'] = $admin_id;

            try {
                $cashbook_model->insert($cashbook);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Cashbook Insert End */

            /* Activity Insert Start */

            $activity = array();
            $activity['fk_user_id'] = $admin_id;
            $activity['activity_type'] = 'success';
            $activity['activity_name'] = 'Fund Created - ' . $customer_id;
            $activity['ip_address'] = getUserIpAddr();
            $activity['visitor_country'] = ip_info('Visitor', 'Country');
            $activity['visitor_state'] = ip_info('Visitor', 'State');
            $activity['visitor_city'] = ip_info('Visitor', 'City');
            $activity['visitor_address'] = ip_info('Visitor', 'Address');
            $activity['create_time'] = current_time();
            $activity['create_date'] = current_date();
            $activity['created_by'] = $admin_id;

            try {
                $activity_model->insert($activity);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Activity Insert End */

            echo 'success';
            exit();
        endif;
    }

    public function manage_funds() {
        $permission_status = $this->check_permission('view_fund');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Funds';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('user/funds', $data);
        return view('dashboard/master', $data);
    }

    public function fund_datatable() {
        $permission_status = $this->check_permission('view_fund');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $balance_model = new BalanceModel();
        $balances = $balance_model
                        ->select('balances.balance_id, users.first_name, users.last_name, users.user_mobile, balances.balance_amount, balances.create_date, balances.modify_date')
                        ->join('users', 'users.user_id = balances.fk_user_id')->find();

        $settings = $this->data['settings'];

        $data = [];
        foreach ($balances as $r) {
            $data[] = array(
                $r['balance_id'],
                $r['first_name'],
                $r['last_name'],
                $r['user_mobile'],
                $r['balance_amount'],
                date($settings['date_format'], strtotime($r['modify_date'] ? $r['modify_date'] : $r['create_date'])),
            );
        }
        $result = array(
            "recordsTotal" => $balance_model->countAll(),
            "recordsFiltered" => $balance_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function fund_transactions() {
        $permission_status = $this->check_permission('view_fund_transaction');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Fund Transactions';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('user/fund_transactions', $data);
        return view('dashboard/master', $data);
    }

    public function transaction_datatable() {
        $permission_status = $this->check_permission('add_fund_transaction');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $transaction_model = new TransactionModel();
        $transactions = $transaction_model
                        ->select('transactions.transaction_id, users.first_name, users.last_name, users.user_mobile, transactions.transaction_amount, transactions.paid_amount, transactions.due_amount, transactions.create_date')
                        ->join('users', 'users.user_id = transactions.fk_reference_id')->where('transaction_type', 'user_fund')->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($transactions as $r) {
            $data[] = array(
                $r['transaction_id'],
                $r['first_name'],
                $r['last_name'],
                $r['user_mobile'],
                $r['transaction_amount'],
                $r['paid_amount'],
                $r['due_amount'],
                date($settings['date_format'], strtotime($r['create_date'])),
            );
        }
        $result = array(
            "recordsTotal" => $transaction_model->countAll(),
            "recordsFiltered" => $transaction_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }
}