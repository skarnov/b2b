<?php

namespace App\Controllers;

use App\Models\PartnerModel;
use App\Models\ActivityModel;
use App\Models\TransactionModel;
use App\Models\CashbookModel;

class Partner extends BaseController
{
    /**
     * Resources
     * 001. Partners
     * 002. Investment
     */
    /* 001. Partners */

    public function index()
    {
        $permission_status = $this->check_permission('view_partner');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Partners';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('partner/partners', $data);
        return view('dashboard/master', $data);
    }

    public function partner_datatable()
    {
        $permission_status = $this->check_permission('view_partner');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $partners = $partner_model->find();

        $settings = $this->data['settings'];

        $data = [];
        foreach ($partners as $r) {
            $data[] = array(
                $r['partner_id'],
                $r['partner_name'],
                $r['total_investment'],
                $r['total_profit'],
                ucfirst($r['partner_status']),
                date($settings['date_format'], strtotime($r['create_date'])),
                '<a class="btn btn-primary btn-xs" href="' . base_url() . '/partner/edit_partner/' . $r['partner_id'] . '">Edit</a>'
            );
        }
        $result = array(
            "recordsTotal" => $partner_model->countAll(),
            "recordsFiltered" => $partner_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function edit_partner($partner_id)
    {
        $permission_status = $this->check_permission('edit_partner');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();

        $data = array();
        $data['title'] = 'Edit Partner';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['partner_info'] = $partner_model->where('partner_id', $partner_id)->first();
        $data['home'] = view('partner/edit_partner', $data);
        return view('dashboard/master', $data);
    }

    public function update_partner()
    {
        $permission_status = $this->check_permission('edit_partner');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $partner_id = $this->request->getPost('partner_id');

        $data = array();
        $data['partner_name'] = $this->request->getPost('name');
        $data['partner_status'] = $this->request->getPost('status');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $partner_model
                ->where('partner_id', $partner_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = $data['partner_name'] . ' Partner Updated - ' . $partner_id;
        $activity['ip_address'] = getUserIpAddr();
        $activity['visitor_country'] = ip_info('Visitor', 'Country');
        $activity['visitor_state'] = ip_info('Visitor', 'State');
        $activity['visitor_city'] = ip_info('Visitor', 'City');
        $activity['visitor_address'] = ip_info('Visitor', 'Address');
        $activity['modify_time'] = current_time();
        $activity['modify_date'] = current_date();
        $activity['modified_by'] = $admin_id;

        try {
            $activity_model->insert($activity);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert End */

        echo 'success';
        exit();
    }

    public function add_partner()
    {
        $permission_status = $this->check_permission('add_partner');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Add Partner';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('partner/add_partner', $data);
        return view('dashboard/master', $data);
    }

    public function save_partner()
    {
        $permission_status = $this->check_permission('add_partner');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');

        $data = array();
        $data['partner_name'] = $this->request->getPost('name');
        $data['partner_status'] = $this->request->getPost('status');
        $data['create_time'] = current_time();
        $data['create_date'] = current_date();
        $data['created_by'] = $admin_id;

        try {
            $partner_model->save($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $fk_partner_id = $partner_model->getInsertID();

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'New Partner Created - ' . $fk_partner_id;
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

    /* 002. Investment */

    public function add_investment()
    {
        $permission_status = $this->check_permission('add_investment');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();

        $data = array();
        $data['title'] = 'Add Investment';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_partners'] = $partner_model->where('partner_status', 'active')->find();
        $data['home'] = view('partner/add_investment', $data);
        return view('dashboard/master', $data);
    }

    public function findPartnerInvestment($partner_id)
    {
        $permission_status = $this->check_permission('add_investment');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $investment = $partner_model->where('partner_id', $partner_id)->first();

        if ($investment) :
            echo $investment['total_investment'];
            exit();
        else :
            echo 0;
            exit();
        endif;
    }

    public function save_investment()
    {
        $permission_status = $this->check_permission('add_investment');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $partner_model = new PartnerModel();
        $cashbook_model = new CashbookModel();
        $transaction_model = new TransactionModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $partner_id = $this->request->getPost('partner_id');
        $add_investment = $this->request->getPost('add_investment');
        $transaction_date = $this->request->getPost('transaction_date');

        $investment = $partner_model->where('partner_id', $partner_id)->first();

        if ($investment) :
            $data = array();
            $data['total_investment'] = $investment['total_investment'] + $add_investment;
            $data['modify_time'] = current_time();
            $data['modify_date'] = current_date();
            $data['modified_by'] = $admin_id;

            try {
                $partner_model
                    ->where('partner_id', $partner_id)
                    ->set($data)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Transaction Insert Start */

            $transaction = array();
            $transaction['transaction_date'] = $transaction_date;
            $transaction['transaction_type'] = 'partner_investment';
            $transaction['fk_reference_id'] = $partner_id;
            $transaction['transaction_amount'] = $add_investment;
            $transaction['paid_amount'] = $add_investment;
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
            $cashbook['table_name'] = 'partners';
            $cashbook['fk_reference_id'] = $partner_id;
            $cashbook['cashbook_description'] = 'Partner Investment';
            $cashbook['out_amount'] = $add_investment;
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
            $activity['activity_name'] = 'New Investment Provided - ' . $partner_id;
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

    public function investment_transactions()
    {
        $permission_status = $this->check_permission('view_investment');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Investment Transactions';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('partner/investment_transactions', $data);
        return view('dashboard/master', $data);
    }

    public function transaction_datatable()
    {
        $permission_status = $this->check_permission('view_investment');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $transaction_model = new TransactionModel();
        $transactions = $transaction_model
            ->select('transactions.transaction_id, partners.partner_name, transactions.transaction_amount, transactions.paid_amount, transactions.due_amount, transactions.create_date')
            ->join('partners', 'partners.partner_id = transactions.fk_reference_id')
            ->where('transaction_type', 'partner_investment')->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($transactions as $r) {
            $data[] = array(
                $r['transaction_id'],
                $r['partner_name'],
                $r['transaction_amount'],
                $r['paid_amount'],
                $r['due_amount'],
                date($settings['date_format'], strtotime($r['create_date']))
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
