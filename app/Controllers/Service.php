<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BalanceModel;
use App\Models\ServiceModel;
use App\Models\SaleModel;
use App\Models\TransactionModel;
use App\Models\IncomeModel;
use App\Models\CashbookModel;
use App\Models\ActivityModel;

class Service extends BaseController {
    /**
     * Resources
     * 001. Services
     * 002. Transactions
     */
    /* 001. Services */

    public function index() {
        $permission_status = $this->check_permission('view_service');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Service Management';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('service/services', $data);
        return view('dashboard/master', $data);
    }

    public function service_datatable() {
        $permission_status = $this->check_permission('view_service');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $service_model = new ServiceModel();
        $services = $service_model
                        ->select('services.service_id, services.expiry_date, services.service_name, users.first_name, users.last_name, services.service_status')
                        ->join('users', 'users.user_id = services.fk_user_id')->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($services as $r) {
            $data[] = array(
                $r['service_id'],
                date($settings['date_format'], strtotime($r['expiry_date'])),
                $r['service_name'],
                $r['first_name'] . ' ' . $r['last_name'],
                ucfirst($r['service_status']),
                '<div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Options
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 38px, 0px);">
                        <a class="dropdown-item" href="' . base_url() . '/service/edit_service/' . $r['service_id'] . '">Edit</a>
                        <a class="dropdown-item" href="' . base_url() . '/service/invoice/' . $r['service_id'] . '">Invoice</a>
                    </div>
                </div>'
            );
        }
        $result = array(
            "recordsTotal" => $service_model->countAll(),
            "recordsFiltered" => $service_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function add_service() {
        $permission_status = $this->check_permission('add_service');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();

        $data = array();
        $data['title'] = 'Add New Service';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_users'] = $user_model->where('user_status', 'active')->find();
        $data['home'] = view('service/add_service', $data);
        return view('dashboard/master', $data);
    }

    public function save_service() {
        $permission_status = $this->check_permission('add_service');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $balance_model = new BalanceModel();
        $service_model = new ServiceModel();
        $sale_model = new SaleModel();
        $transaction_model = new TransactionModel();
        $income_model = new IncomeModel();
        $cashbook_model = new CashbookModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $user_id = $this->request->getPost('user_id');
        $buying_price = $this->request->getPost('buying_price');
        $user_balance = $balance_model->where('fk_user_id', $user_id)->first()['balance_amount'];

        if (!($user_balance >= $buying_price)) :
            echo 'Customer Has Insufficient Balance';
            exit();
        endif;

        /* Service Insert Start */

        $service = array();
        $service['fk_user_id'] = $user_id;
        $service['service_name'] = $this->request->getPost('service_name');
        $service['service_url'] = $this->request->getPost('service_url');
        $service['service_username'] = $this->request->getPost('service_username');
        $service['service_password'] = $this->request->getPost('service_password');
        $service['service_note'] = $this->request->getPost('note');
        $service['expiry_date'] = $this->request->getPost('expiry_date');
        $service['service_status'] = $this->request->getPost('status');
        $service['create_time'] = current_time();
        $service['create_date'] = current_date();
        $service['created_by'] = $admin_id;

        try {
            $service_model->save($service);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $fk_service_id = $service_model->getInsertID();

        $invoice = date('y') . $user_id . $fk_service_id;
        $invoice_id = str_pad($invoice, 8, '0', STR_PAD_LEFT);

        /* Service Insert End */

        if ($fk_service_id) {
            $net_price = $this->request->getPost('net_price');
            $discount = $this->request->getPost('discount_amount') ? $this->request->getPost('discount_amount') : 0;
            $sale_due = $this->request->getPost('sale_due');
            $paid_amount = $this->request->getPost('paid_amount');
            $transaction_date = $this->request->getPost('transaction_date');
            $profit = $net_price - $buying_price;

            $date_calc = abs(strtotime($service['create_date']) - strtotime($service['expiry_date']));
            $years = floor($date_calc / (365 * 60 * 60 * 24));

            /* Sale Insert Start */

            $sale = array();
            $sale['table_name'] = 'services';
            $sale['fk_reference_id'] = $fk_service_id;
            $sale['fk_user_id'] = $user_id;
            $sale['invoice_id'] = $invoice_id;
            $sale['sale_description'] = 'Service Sale: ' . $service['service_name'] . ' For ' . $years . ' Years.';
            $sale['due_date'] = $service['expiry_date'];
            $sale['net_price'] = $net_price;
            $sale['discount_amount'] = $discount;
            $sale['grand_total'] = $net_price - $discount;
            $sale['buying_price'] = $buying_price;
            $sale['sale_due'] = $sale_due - $paid_amount;
            $sale['sale_status'] = $service['service_status'];
            $sale['create_time'] = current_time();
            $sale['create_date'] = current_date();
            $sale['created_by'] = $admin_id;

            try {
                $sale_model->save($sale);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            $fk_sale_id = $sale_model->getInsertID();

            /* Sale Insert End */

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
            $transaction['transaction_date'] = $transaction_date;
            $transaction['transaction_type'] = 'sale';
            $transaction['fk_reference_id'] = $fk_sale_id;
            $transaction['transaction_amount'] = $net_price - $discount;
            $transaction['paid_amount'] = $paid_amount;
            $transaction['due_amount'] = $net_price - $discount - $paid_amount;
            $transaction['create_time'] = current_time();
            $transaction['create_date'] = current_date();
            $transaction['created_by'] = $admin_id;

            try {
                $transaction_model->save($transaction);
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
                $income_model->save($income);
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
                $cashbook_model->save($cashbook);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Cashbook Insert End */

            /* Activity Insert Start */

            $activity = array();
            $activity['fk_user_id'] = $admin_id;
            $activity['activity_type'] = 'success';
            $activity['activity_name'] = 'New Service Created - ' . $fk_service_id;
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

    public function edit_service($service_id) {
        $permission_status = $this->check_permission('edit_service');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $user_model = new UserModel();
        $service_model = new ServiceModel();

        $data = array();
        $data['title'] = 'Edit The Service';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_users'] = $user_model->where('user_status', 'active')->find();
        $data['service_info'] = $service_model->where('service_id', $service_id)->first();
        $data['home'] = view('service/edit_service', $data);
        return view('dashboard/master', $data);
    }

    public function update_service() {
        $permission_status = $this->check_permission('edit_service');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $service_model = new ServiceModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $service_id = $this->request->getPost('service_id');

        /* Service Update Start */

        $service = array();
        $service['service_name'] = $this->request->getPost('service_name');
        $service['service_url'] = $this->request->getPost('service_url');
        $service['service_username'] = $this->request->getPost('service_username');
        $service['service_password'] = $this->request->getPost('service_password');
        $service['service_note'] = $this->request->getPost('note');
        $service['expiry_date'] = $this->request->getPost('expiry_date');
        $service['service_status'] = $this->request->getPost('status');
        $service['modify_time'] = current_time();
        $service['modify_date'] = current_date();
        $service['modified_by'] = $admin_id;

        try {
            $service_model
                    ->where('service_id', $service_id)
                    ->set($service)
                    ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Service Update End */

        /* Invoice Creation Start */

        $service_info = $service_model->where('service_id', $service_id)->first();
        $sale_model = new SaleModel();

        $invoice = date('y', strtotime($service_info['create_date'])) . $service_info['fk_user_id'] . $service_id;
        $invoice_id = str_pad($invoice, 8, '0', STR_PAD_LEFT);

        $sale = array();
        $sale['invoice_id'] = $invoice_id;

        try {
            $sale_model
                    ->where('table_name', 'services')
                    ->where('fk_reference_id', $service_id)
                    ->set($sale)
                    ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Invoice Creation End */

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'Service Edited - ' . $service_id;
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

    public function invoice($id) {
        $permission_status = $this->check_permission('service_invoice');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $service_model = new ServiceModel();

        $all_invoices = $service_model
                ->select('services.service_name, sales.sale_id, sales.create_date, sales.buying_price, sales.net_price, sales.vat_amount, sales.discount_amount, sales.grand_total, sales.sale_due')
                ->join('sales', 'sales.fk_reference_id = services.service_id')
                ->join('users', 'users.user_id = services.fk_user_id')
                ->where('sales.table_name', 'services')
                ->where('services.service_id', $id)
                ->orderBy('sales.sale_id', 'DESC')
                ->find();

        $data = array();
        $data['title'] = $all_invoices[0]['service_name'] . ' - Invoices';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_invoices'] = $all_invoices;
        $data['home'] = view('service/invoice', $data);
        return view('dashboard/master', $data);
    }

    /* 002. Transactions */

    public function transactions() {
        $permission_status = $this->check_permission('service_transaction');
        if ($permission_status):
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
        $data['home'] = view('service/transactions', $data);
        return view('dashboard/master', $data);
    }

    public function transaction_datatable() {
        $permission_status = $this->check_permission('view_service_transaction');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $transaction_model = new TransactionModel();
        $transactions = $transaction_model
                ->select('transactions.transaction_id, transactions.transaction_date, transactions.transaction_amount, transactions.paid_amount, transactions.due_amount')
                ->join('sales', 'sales.sale_id = transactions.fk_reference_id')
                ->where('sales.table_name', 'services')
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

    public function add_transaction() {
        $permission_status = $this->check_permission('add_service_transaction');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();
        $sales = $sale_model
                ->where('table_name', 'services')
                ->where("sale_due != '0'")
                ->find();

        $data = array();
        $data['title'] = 'Transactions';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_sales'] = $sales;
        $data['home'] = view('service/add_transaction', $data);
        return view('dashboard/master', $data);
    }

    public function findSaleDue($sale_id) {
        $permission_status = $this->check_permission('add_service_transaction');
        if ($permission_status):
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();
        $due = $sale_model->where('sale_id', $sale_id)->first()['sale_due'];
        echo $due ? $due : 0;
        exit();
    }

    public function save_transaction() {
        $permission_status = $this->check_permission('add_service_transaction');
        if ($permission_status):
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

        if ($sale_info):
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
}