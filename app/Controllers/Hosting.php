<?php

namespace App\Controllers;

use App\Models\HostingModel;
use App\Models\HostingPackageModel;
use App\Models\PartnerModel;
use App\Models\UserModel;
use App\Models\SaleModel;
use App\Models\BalanceModel;
use App\Models\TransactionModel;
use App\Models\IncomeModel;
use App\Models\CashbookModel;
use App\Models\ActivityModel;

class Hosting extends BaseController
{
    /**
     * Resources
     * 001. Hosting
     * 002. Transactions
     * 003. Hosting Packages
     */
    /* 001. Hosting */

    public function index()
    {
        $permission_status = $this->check_permission('view_hosting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Hosting';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('hosting/hostings', $data);
        return view('dashboard/master', $data);
    }

    public function hosting_datatable()
    {
        $permission_status = $this->check_permission('view_hosting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $hosting_model = new HostingModel();
        $hostings = $hosting_model
            ->select('hostings.hosting_id, hostings.expiry_date, hostings.hosting_space, hostings.primary_domain, users.first_name, users.last_name, hostings.hosting_mobile, hostings.hosting_email, hostings.hosting_status')
            ->join('users', 'users.user_id = hostings.fk_user_id')
            ->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($hostings as $r) {
            $data[] = array(
                $r['hosting_id'],
                date($settings['date_format'], strtotime($r['expiry_date'])),
                $r['hosting_space'],
                $r['primary_domain'],
                $r['first_name'],
                $r['last_name'],
                $r['hosting_mobile'],
                $r['hosting_email'],
                ucfirst($r['hosting_status']),
                '<div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                        <a class="dropdown-item" href="' . base_url() . '/hosting/edit_hosting/' . $r['hosting_id'] . '">Edit</a>
                        <a class="dropdown-item" href="' . base_url() . '/hosting/renew/' . $r['hosting_id'] . '">Renew</a>
                        <a class="dropdown-item" href="' . base_url() . '/hosting/invoice/' . $r['hosting_id'] . '" target="_blank">Invoice</a>
                    </div>
                </div>'
            );
        }
        $result = array(
            "recordsTotal" => $hosting_model->countAll(),
            "recordsFiltered" => $hosting_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function add_hosting()
    {
        $permission_status = $this->check_permission('add_hosting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $user_model = new UserModel();
        $package_model = new HostingPackageModel();

        $data = array();
        $data['title'] = 'Add Hosting';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_partners'] = $partner_model->where('partner_status', 'active')->find();
        $data['all_users'] = $user_model->where('user_status', 'active')->find();
        $data['all_packages'] = $package_model->where('package_status', 'active')->find();
        $data['home'] = view('hosting/add_hosting', $data);
        return view('dashboard/master', $data);
    }

    public function save_hosting()
    {
        $permission_status = $this->check_permission('add_hosting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $balance_model = new BalanceModel();
        $partner_model = new PartnerModel();
        $hosting_model = new HostingModel();
        $sale_model = new SaleModel();
        $transaction_model = new TransactionModel();
        $income_model = new IncomeModel();
        $cashbook_model = new CashbookModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $user_id = $this->request->getPost('user_id');
        $partner_id = $this->request->getPost('partner_id');
        $net_price = $this->request->getPost('net_price');
        $buying_price = $this->request->getPost('buying_price');
        $paid_amount = $this->request->getPost('paid_amount');
        $hosting_status = $this->request->getPost('status');
        $discount = $this->request->getPost('discount_amount') ? $this->request->getPost('discount_amount') : 0;
        $sale_price = $net_price - $discount;
        $profit = $paid_amount - $buying_price;

        $user_balance = $balance_model->where('fk_user_id', $user_id)->first()['balance_amount'];

        if (!($user_balance >= $buying_price)) :
            echo 'Customer Has Insufficient Balance';
            exit();
        endif;

        $data = array();
        $data['fk_user_id'] = $user_id;
        $data['fk_partner_id'] = $partner_id;
        $data['fk_package_id'] = $this->request->getPost('package_id');
        $data['hosting_space'] = $this->request->getPost('hosting_space');
        $data['primary_domain'] = $this->request->getPost('primary_domain');
        $data['hosting_email'] = $this->request->getPost('hosting_email');
        $data['hosting_mobile'] = $this->request->getPost('hosting_mobile');
        $data['renew_for'] = $this->request->getPost('renew_for');
        $data['renew_date'] = $this->request->getPost('renew_date');
        $data['expiry_date'] = $this->request->getPost('expiry_date');
        $data['cpanel_url'] = $this->request->getPost('cpanel_url');
        $data['cpanel_username'] = $this->request->getPost('cpanel_username');
        $data['cpanel_password'] = $this->request->getPost('cpanel_password');
        $data['email_url'] = $this->request->getPost('email_url');
        $data['email_username'] = $this->request->getPost('email_username');
        $data['email_password'] = $this->request->getPost('email_password');
        $data['hosting_note'] = $this->request->getPost('note');
        $data['hosting_status'] = $hosting_status;
        $data['create_time'] = current_time();
        $data['create_date'] = current_date();
        $data['created_by'] = $admin_id;

        try {
            $hosting_model->insert($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $fk_hosting_id = $hosting_model->getInsertID();

        $invoice = date('y') . $user_id . $partner_id . $fk_hosting_id;
        $invoice_id = str_pad($invoice, 8, '0', STR_PAD_LEFT);

        if ($hosting_status == 'active') :

            /* Sale Insert Start */

            $sale = array();
            $sale['table_name'] = 'hostings';
            $sale['fk_reference_id'] = $fk_hosting_id;
            $sale['fk_user_id'] = $user_id;
            $sale['fk_partner_id'] = $partner_id;
            $sale['invoice_id'] = $invoice_id;
            $sale['sale_description'] = 'Hosting Sale: ' . $data['primary_domain'] . ' (' . $data['hosting_space'] . ') ' . 'For ' .  $data['renew_for'];
            $sale['due_date'] = $this->request->getPost('expiry_date');
            $sale['net_price'] = $net_price;
            $sale['discount_amount'] = $discount;
            $sale['grand_total'] = $sale_price;
            $sale['buying_price'] = $buying_price;
            $sale['sale_due'] = $this->request->getPost('sale_due') - $paid_amount;
            $sale['sale_status'] = 'active';
            $sale['sale_note'] = $this->request->getPost('note');
            $sale['create_time'] = current_time();
            $sale['create_date'] = current_date();
            $sale['created_by'] = $admin_id;

            try {
                $sale_model->insert($sale);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_sale_id = $sale_model->getInsertID();

            /* Sale Insert End */

            /* Partner Update Start */

            $total_profit = $partner_model->where('partner_id', $partner_id)->first()['total_profit'];

            $partner = array();
            $partner['total_profit'] = $total_profit + $profit;
            $partner['modify_time'] = current_time();
            $partner['modify_date'] = current_date();
            $partner['modified_by'] = $admin_id;

            try {
                $partner_model
                    ->where('partner_id', $partner_id)
                    ->set($partner)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Partner Update End */

            /* Balance Update Start */

            $balance = array();
            $balance['balance_amount'] = $user_balance - $paid_amount;
            $balance['modify_time'] = current_time();
            $balance['modify_date'] = current_date();
            $balance['modified_by'] = $admin_id;

            try {
                $balance_model
                    ->where('fk_user_id', $user_id)
                    ->set($balance)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Balance Update End */

            /* Transaction Insert Start */

            $transaction = array();
            $transaction['transaction_date'] = $this->request->getPost('transaction_date');
            $transaction['transaction_type'] = 'sale';
            $transaction['fk_reference_id'] = $fk_sale_id;
            $transaction['transaction_amount'] = $sale_price;
            $transaction['paid_amount'] = $paid_amount;
            $transaction['due_amount'] = $net_price - $discount - $paid_amount;
            $transaction['create_time'] = current_time();
            $transaction['create_date'] = current_date();
            $transaction['created_by'] = $admin_id;

            try {
                $transaction_model->insert($transaction);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_transaction_id = $transaction_model->getInsertID();

            /* Transaction Insert End */

            /* Income Insert Start */
            $income = array();
            $income['fk_transaction_id'] = $fk_transaction_id;
            $income['income_description'] = $sale['sale_description'];
            $income['income_amount'] = $profit;
            $income['create_time'] = current_time();
            $income['create_date'] = current_date();
            $income['created_by'] = $admin_id;

            try {
                $income_model->insert($income);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_income_id = $income_model->getInsertID();

            /* Income Insert End */

            /* Cashbook Insert Start */

            $cashbook = array();
            $cashbook['table_name'] = 'incomes';
            $cashbook['fk_reference_id'] = $fk_income_id;
            $cashbook['cashbook_description'] = $income['income_description'];
            $cashbook['in_amount'] = $profit;
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
            $activity['activity_name'] = 'Domain Created - ' . $data['primary_domain'] . ' (' . $data['hosting_space'] . ')';
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
        endif;

        echo 'success';
        exit();
    }

    public function edit_hosting($hosting_id)
    {
        $permission_status = $this->check_permission('edit_hosting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $user_model = new UserModel();
        $hosting_model = new HostingModel();
        $package_model = new HostingPackageModel();

        $data = array();
        $data['title'] = 'Edit Hosting';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_partners'] = $partner_model->where('partner_status', 'active')->find();
        $data['all_users'] = $user_model->where('user_status', 'active')->find();
        $data['all_packages'] = $package_model->where('package_status', 'active')->find();
        $data['hosting_info'] = $hosting_model->where('hosting_id', $hosting_id)->first();
        $data['home'] = view('hosting/edit_hosting', $data);
        return view('dashboard/master', $data);
    }

    public function update_hosting()
    {
        $permission_status = $this->check_permission('edit_hosting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $hosting_model = new HostingModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $hosting_id = $this->request->getPost('hosting_id');

        $data = array();
        $data['fk_package_id'] = $this->request->getPost('package_id');
        $data['hosting_space'] = $this->request->getPost('hosting_space');
        $data['primary_domain'] = $this->request->getPost('primary_domain');
        $data['hosting_email'] = $this->request->getPost('hosting_email');
        $data['hosting_mobile'] = $this->request->getPost('hosting_mobile');
        $data['renew_for'] = $this->request->getPost('renew_for');
        $data['renew_date'] = $this->request->getPost('renew_date');
        $data['expiry_date'] = $this->request->getPost('expiry_date');
        $data['cpanel_url'] = $this->request->getPost('cpanel_url');
        $data['cpanel_username'] = $this->request->getPost('cpanel_username');
        $data['cpanel_password'] = $this->request->getPost('cpanel_password');
        $data['email_url'] = $this->request->getPost('email_url');
        $data['email_username'] = $this->request->getPost('email_username');
        $data['email_password'] = $this->request->getPost('email_password');
        $data['hosting_note'] = $this->request->getPost('note');
        $data['hosting_status'] = $this->request->getPost('status');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $hosting_model
                ->where('hosting_id', $hosting_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Invoice Creation Start */

        $hosting_info = $hosting_model->where('hosting_id', $hosting_id)->first();
        $sale_model = new SaleModel();

        $invoice = date('y', strtotime($hosting_info['create_date'])) . $hosting_info['fk_user_id'] . $hosting_info['fk_partner_id'] . $hosting_id;
        $invoice_id = str_pad($invoice, 8, '0', STR_PAD_LEFT);

        $sale = array();
        $sale['invoice_id'] = $invoice_id;

        try {
            $sale_model
                ->where('table_name', 'hostings')
                ->where('fk_reference_id', $hosting_id)
                ->set($sale)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Invoice Creation End */

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Hosting Updated - ID' . $hosting_id;
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
    }

    public function renew($hosting_id)
    {
        $permission_status = $this->check_permission('hosting_renew');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $user_model = new UserModel();
        $hosting_model = new HostingModel();
        $package_model = new HostingPackageModel();

        $data = array();
        $data['title'] = 'Hosting Renew';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_partners'] = $partner_model->where('partner_status', 'active')->find();
        $data['all_users'] = $user_model->where('user_status', 'active')->find();
        $data['all_packages'] = $package_model->where('package_status', 'active')->find();
        $data['hosting_info'] = $hosting_model->join('users', 'users.user_id = hostings.fk_user_id')->where('hosting_id', $hosting_id)->first();
        $data['home'] = view('hosting/hosting_renew', $data);
        return view('dashboard/master', $data);
    }

    public function hosting_renew()
    {
        $permission_status = $this->check_permission('hosting_renew');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $hosting_model = new HostingModel();
        $balance_model = new BalanceModel();
        $partner_model = new PartnerModel();
        $sale_model = new SaleModel();
        $transaction_model = new TransactionModel();
        $income_model = new IncomeModel();
        $cashbook_model = new CashbookModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $hosting_id = $this->request->getPost('hosting_id');
        $user_id = $this->request->getPost('user_id');
        $partner_id = $this->request->getPost('partner_id');
        $net_price = $this->request->getPost('net_price');
        $buying_price = $this->request->getPost('buying_price');
        $paid_amount = $this->request->getPost('paid_amount');
        $hosting_status = $this->request->getPost('status');
        $discount = $this->request->getPost('discount_amount') ? $this->request->getPost('discount_amount') : 0;
        $sale_price = $net_price - $discount;
        $profit = $paid_amount - $buying_price;

        $hosting_name = $hosting_model->where('hosting_id', $hosting_id)->first()['primary_domain'];
        $user_balance = $balance_model->where('fk_user_id', $user_id)->first()['balance_amount'];
        $remaining_investment = $partner_model->where('partner_id', $partner_id)->first();

        if (!($user_balance >= $buying_price)) :
            echo 'Customer Has Insufficient Balance';
            exit();
        endif;

        $data['fk_user_id'] = $user_id;
        $data['fk_partner_id'] = $partner_id;
        $data['fk_package_id'] = $this->request->getPost('package_id');
        $data['hosting_space'] = $this->request->getPost('hosting_space');
        $data['primary_domain'] = $this->request->getPost('primary_domain');
        $data['hosting_email'] = $this->request->getPost('hosting_email');
        $data['hosting_mobile'] = $this->request->getPost('hosting_mobile');
        $data['renew_for'] = $this->request->getPost('renew_for');
        $data['renew_date'] = $this->request->getPost('renew_date');
        $data['expiry_date'] = $this->request->getPost('expiry_date');
        $data['cpanel_url'] = $this->request->getPost('cpanel_url');
        $data['cpanel_username'] = $this->request->getPost('cpanel_username');
        $data['cpanel_password'] = $this->request->getPost('cpanel_password');
        $data['email_url'] = $this->request->getPost('email_url');
        $data['email_username'] = $this->request->getPost('email_username');
        $data['email_password'] = $this->request->getPost('email_password');
        $data['hosting_note'] = $this->request->getPost('note');
        $data['hosting_status'] = $hosting_status;
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $hosting_model
                ->where('hosting_id', $hosting_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $invoice = date('y') . $user_id . $partner_id . $hosting_id;
        $invoice_id = str_pad($invoice, 8, '0', STR_PAD_LEFT);

        if ($hosting_status == 'active') {

            /* Sale Insert Start */

            $sale = array();
            $sale['table_name'] = 'hostings';
            $sale['fk_reference_id'] = $hosting_id;
            $sale['fk_user_id'] = $user_id;
            $sale['fk_partner_id'] = $partner_id;
            $sale['invoice_id'] = $invoice_id;
            $sale['sale_description'] = 'Hosting Sale: ' . $data['primary_domain'] . ' (' . $data['hosting_space'] . ') ' . 'For ' . $data['renew_for'];
            $sale['due_date'] = $this->request->getPost('expiry_date');
            $sale['net_price'] = $net_price;
            $sale['discount_amount'] = $discount;
            $sale['grand_total'] = $sale_price;
            $sale['buying_price'] = $buying_price;
            $sale['sale_due'] = $this->request->getPost('sale_due') - $paid_amount;
            $sale['sale_status'] = 'active';
            $sale['sale_note'] = $this->request->getPost('note');
            $sale['create_time'] = current_time();
            $sale['create_date'] = current_date();
            $sale['created_by'] = $admin_id;

            try {
                $sale_model->insert($sale);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_sale_id = $sale_model->getInsertID();

            /* Sale Insert End */

            /* Partner Update Start */

            $total_profit = $partner_model->where('partner_id', $partner_id)->first()['total_profit'];

            $partner = array();
            $partner['total_profit'] = $total_profit + $profit;
            $partner['modify_time'] = current_time();
            $partner['modify_date'] = current_date();
            $partner['modified_by'] = $admin_id;

            try {
                $partner_model
                    ->where('partner_id', $partner_id)
                    ->set($partner)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Partner Update End */

            /* Balance Update Start */

            $balance = array();
            $balance['balance_amount'] = $user_balance - $paid_amount;
            $balance['modify_time'] = current_time();
            $balance['modify_date'] = current_date();
            $balance['modified_by'] = $admin_id;

            try {
                $balance_model
                    ->where('fk_user_id', $user_id)
                    ->set($balance)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Balance Update End */

            /* Transaction Insert Start */

            $transaction = array();
            $transaction['transaction_date'] = $this->request->getPost('transaction_date');
            $transaction['transaction_type'] = 'sale';
            $transaction['fk_reference_id'] = $fk_sale_id;
            $transaction['transaction_amount'] = $sale_price;
            $transaction['paid_amount'] = $paid_amount;
            $transaction['due_amount'] = $net_price - $discount - $paid_amount;
            $transaction['create_time'] = current_time();
            $transaction['create_date'] = current_date();
            $transaction['created_by'] = $admin_id;

            try {
                $transaction_model->insert($transaction);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_transaction_id = $transaction_model->getInsertID();

            /* Transaction Insert End */

            /* Income Insert Start */

            $income = array();
            $income['fk_transaction_id'] = $fk_transaction_id;
            $income['income_description'] = $sale['sale_description'];
            $income['income_amount'] = $profit;
            $income['create_time'] = current_time();
            $income['create_date'] = current_date();
            $income['created_by'] = $admin_id;

            try {
                $income_model->insert($income);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_income_id = $income_model->getInsertID();

            /* Income Insert End */

            /* Cashbook Insert Start */

            $cashbook = array();
            $cashbook['table_name'] = 'incomes';
            $cashbook['fk_reference_id'] = $fk_income_id;
            $cashbook['cashbook_description'] = $income['income_description'];
            $cashbook['in_amount'] = $profit;
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
            $activity['activity_name'] = 'Hosting Renewed - ' . $hosting_name;
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
        }
    }

    public function invoice($id)
    {
        $permission_status = $this->check_permission('hosting_invoice');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $hosting_model = new HostingModel();

        $all_invoices = $hosting_model
            ->select('hostings.primary_domain, sales.sale_id, sales.create_date, sales.buying_price, sales.net_price, sales.vat_amount, sales.discount_amount, sales.grand_total, sales.sale_due')
            ->join('sales', 'sales.fk_reference_id = hostings.hosting_id')
            ->join('users', 'users.user_id = hostings.fk_user_id')
            ->where('sales.table_name', 'hostings')
            ->where('hostings.hosting_id', $id)
            ->orderBy('sales.sale_id', 'DESC')
            ->find();

        $data = array();
        $data['title'] = $all_invoices[0]['primary_domain'] . ' - Invoices';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_invoices'] = $all_invoices;
        $data['home'] = view('hosting/invoice', $data);
        return view('dashboard/master', $data);
    }

    /* 002. Transactions */

    public function transactions()
    {
        $permission_status = $this->check_permission('view_hosting_transaction');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Transactions';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('hosting/transactions', $data);
        return view('dashboard/master', $data);
    }

    public function transaction_datatable()
    {
        $permission_status = $this->check_permission('view_hosting_transaction');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $transaction_model = new TransactionModel();
        $transactions = $transaction_model
            ->select('transactions.transaction_id, transactions.transaction_date, transactions.transaction_amount, transactions.paid_amount, transactions.due_amount')
            ->join('sales', 'sales.sale_id = transactions.fk_reference_id')
            ->where('transaction_type', 'sale')
            ->where('sales.table_name', 'hostings')
            ->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($transactions as $r) {
            $data[] = array(
                $r['transaction_id'],
                date($settings['date_format'], strtotime($r['transaction_date'])),
                $r['transaction_amount'],
                $r['paid_amount'],
                $r['due_amount']
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

    public function add_transaction()
    {
        $permission_status = $this->check_permission('add_hosting_transaction');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $sale_model = new SaleModel();
        $sales = $sale_model
            ->where('table_name', 'hostings')
            ->where("sale_due != 0")
            ->find();
        $data = array();
        $data['title'] = 'Add Transaction';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_sales'] = $sales;
        $data['home'] = view('hosting/add_transaction', $data);
        return view('dashboard/master', $data);
    }

    public function findSaleDue($sale_id)
    {
        $permission_status = $this->check_permission('add_hosting_transaction');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();
        $due = $sale_model->where('sale_id', $sale_id)->first()['sale_due'];
        echo $due ? $due : 0;
        exit();
    }

    public function save_transaction()
    {
        $permission_status = $this->check_permission('add_hosting_transaction');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();
        $balance_model = new BalanceModel();
        $transaction_model = new TransactionModel();
        $income_model = new IncomeModel();
        $cashbook_model = new CashbookModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $sale_id = $this->request->getPost('sale_id');
        $transaction_amount = $this->request->getPost('add_transaction');
        $transaction_date = $this->request->getPost('transaction_date');

        $sale_info = $sale_model->where('sale_id', $sale_id)->first();

        if ($sale_info) :
            $sale = array();
            $sale['sale_due'] = $sale_info['sale_due'] - $transaction_amount;
            $sale['modify_time'] = current_time();
            $sale['modify_date'] = current_date();
            $sale['modified_by'] = $admin_id;

            try {
                $sale_model
                    ->where('sale_id', $sale_id)
                    ->set($sale)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Balance Update Start */

            $user_balance = $balance_model->where('fk_user_id', $sale_info['fk_user_id'])->first()['balance_amount'];

            $balance = array();
            $balance['balance_amount'] = $user_balance - $transaction_amount;
            $balance['modify_time'] = current_time();
            $balance['modify_date'] = current_date();
            $balance['modified_by'] = $admin_id;

            try {
                $balance_model
                    ->where('fk_user_id', $sale_info['fk_user_id'])
                    ->set($balance)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Balance Update End */

            /* Transaction Insert Start */

            $transaction = array();
            $transaction['transaction_date'] = $transaction_date;
            $transaction['transaction_type'] = 'sale';
            $transaction['fk_reference_id'] = $sale_id;
            $transaction['transaction_amount'] = $transaction_amount;
            $transaction['paid_amount'] = $transaction_amount;
            $transaction['due_amount'] = 0;
            $transaction['create_time'] = current_time();
            $transaction['create_date'] = current_date();
            $transaction['created_by'] = $admin_id;

            try {
                $transaction_model->insert($transaction);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_transaction_id = $transaction_model->getInsertID();

            /* Transaction Insert End */

            /* Income Insert Start */

            $income = array();
            $income['fk_transaction_id'] = $fk_transaction_id;
            $income['income_description'] = $sale_info['sale_description'];
            $income['income_amount'] = $transaction_amount;
            $income['create_time'] = current_time();
            $income['create_date'] = current_date();
            $income['created_by'] = $admin_id;

            try {
                $income_model->insert($income);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_income_id = $income_model->getInsertID();

            /* Income Insert End */

            /* Cashbook Insert Start */

            $cashbook = array();
            $cashbook['table_name'] = 'incomes';
            $cashbook['fk_reference_id'] = $fk_income_id;
            $cashbook['cashbook_description'] = $income['income_description'];
            $cashbook['in_amount'] = $transaction_amount;
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
            $activity['activity_name'] = 'Sale Due Has Updated   - ' . $sale_id;
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
        endif;
        echo 'success';
        exit();
    }

    /* 003. Hosting Packages */

    public function packages()
    {
        $permission_status = $this->check_permission('view_hosting_package');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Hosting Packages';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('hosting/packages', $data);
        return view('dashboard/master', $data);
    }

    public function package_datatable()
    {
        $permission_status = $this->check_permission('view_hosting_package');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $package_model = new HostingPackageModel();
        $packages = $package_model->find();

        $data = [];
        foreach ($packages as $r) {
            $data[] = array(
                $r['package_id'],
                $r['package_name'],
                $r['package_price'],
                $r['package_storage'] . ' GB',
                '<a class="btn btn-primary btn-xs" href="' . base_url() . '/hosting/edit_package/' . $r['package_id'] . '">Edit</a>'
            );
        }
        $result = array(
            "recordsTotal" => $package_model->countAll(),
            "recordsFiltered" => $package_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function add_package()
    {
        $permission_status = $this->check_permission('add_hosting_package');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Add Package';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('hosting/add_package', $data);
        return view('dashboard/master', $data);
    }

    public function save_package()
    {
        $permission_status = $this->check_permission('add_hosting_package');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $package_model = new HostingPackageModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        $data = array();
        $data['package_name'] = $this->request->getPost('package_name');
        $data['package_price'] = $this->request->getPost('package_price');
        $data['website_host'] = $this->request->getPost('website_host');
        $data['database_host'] = $this->request->getPost('database_host');
        $data['package_storage'] = $this->request->getPost('package_storage');
        $data['ftp_account'] = $this->request->getPost('ftp_account');
        $data['email_account'] = $this->request->getPost('email_account');
        $data['package_status'] = $this->request->getPost('package_status');
        $data['create_time'] = current_time();
        $data['create_date'] = current_date();
        $data['created_by'] = $admin_id;

        try {
            $package_model->insert($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = $data['package_name'] . ' Package Has Created';
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
    }

    public function edit_package($package_id)
    {
        $permission_status = $this->check_permission('edit_package');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $package_model = new HostingPackageModel();

        $data = array();
        $data['title'] = 'Edit Package';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['package_info'] = $package_model->where('package_id', $package_id)->first();
        $data['home'] = view('hosting/edit_package', $data);
        return view('dashboard/master', $data);
    }

    public function update_package()
    {
        $permission_status = $this->check_permission('edit_package');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $package_model = new HostingPackageModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $package_id = $this->request->getPost('package_id');

        $data = array();
        $data['package_name'] = $this->request->getPost('package_name');
        $data['package_price'] = $this->request->getPost('package_price');
        $data['website_host'] = $this->request->getPost('website_host');
        $data['database_host'] = $this->request->getPost('database_host');
        $data['package_storage'] = $this->request->getPost('package_storage');
        $data['ftp_account'] = $this->request->getPost('ftp_account');
        $data['email_account'] = $this->request->getPost('email_account');
        $data['package_status'] = $this->request->getPost('package_status');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $package_model
                ->where('package_id', $package_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Package Updated - Package ID ' . $package_id;
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
    }
}
