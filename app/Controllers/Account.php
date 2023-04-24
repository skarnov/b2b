<?php

namespace App\Controllers;

use App\Models\SaleModel;
use App\Models\TransactionModel;
use App\Models\CashbookModel;
use App\Models\IncomeModel;
use App\Models\ActivityModel;

class Account extends BaseController
{
    /**
     * Resources
     * 001. Sales
     * 002. Transactions
     * 003. Cashbook
     * 004. Income
     * 005. Expense
     * 006. Invoice
     */
    /* 001. Sales */

    public function index()
    {
        $permission_status = $this->check_permission('view_sale');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Sales';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('account/sales', $data);
        return view('dashboard/master', $data);
    }

    public function sales_datatable()
    {
        $permission_status = $this->check_permission('view_sale');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();
        $sales = $sale_model
            ->select('sales.sale_id, sales.create_date, sales.sale_description, sales.buying_price, sales.grand_total, sales.sale_due, users.first_name, users.last_name, partners.partner_name, sales.sale_status')
            ->join('users', 'users.user_id = sales.fk_user_id')
            ->join('partners', 'partners.partner_id = sales.fk_partner_id')
            ->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($sales as $r) {
            $data[] = array(
                $r['sale_id'],
                date($settings['date_format'], strtotime($r['create_date'])),
                $r['sale_description'],
                $r['buying_price'],
                $r['grand_total'],
                $r['sale_due'],
                $r['first_name'],
                $r['last_name'],
                $r['partner_name'],
                ucfirst($r['sale_status']),
                '<a class="btn btn-primary btn-xs" href="' . base_url() . '/account/edit_sale/' . $r['sale_id'] . '">Edit</a>'
            );
        }
        $result = array(
            "recordsTotal" => $sale_model->countAll(),
            "recordsFiltered" => $sale_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function edit_sale($sale_id)
    {
        $permission_status = $this->check_permission('edit_sale');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();

        $data = array();
        $data['title'] = 'Edit Sale';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['sale_info'] = $sale_model->where('sale_id', $sale_id)->first();
        $data['home'] = view('account/edit_sale', $data);
        return view('dashboard/master', $data);
    }

    public function update_sale()
    {
        $permission_status = $this->check_permission('edit_sale');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $sale_model = new SaleModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $sale_id = $this->request->getPost('sale_id');

        $data = array();
        $data['invoice_id'] = $this->request->getPost('invoice_id');
        $data['sale_description'] = $this->request->getPost('sale_description');
        $data['sale_status'] = $this->request->getPost('status');
        $data['sale_note'] = $this->request->getPost('sale_note');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $sale_model
                ->where('sale_id', $sale_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Sale Updated - Sale ID ' . $sale_id;
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

    /* 002. Transactions */

    public function transactions()
    {
        $permission_status = $this->check_permission('view_sale_transaction');
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
        $data['home'] = view('account/transactions', $data);
        return view('dashboard/master', $data);
    }

    public function transaction_datatable()
    {
        $permission_status = $this->check_permission('view_sale_transaction');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $transaction_model = new TransactionModel();
        $transactions = $transaction_model
            ->select('transactions.transaction_id, transactions.transaction_date, transactions.transaction_amount, transactions.paid_amount, transactions.due_amount')
            ->join('sales', 'sales.sale_id = transactions.fk_reference_id')
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

    /* 003. Cashbook */

    public function cashbook()
    {
        $permission_status = $this->check_permission('view_cashbook');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Cashbook';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('account/cashbook', $data);
        return view('dashboard/master', $data);
    }

    public function cashbook_datatable()
    {
        $permission_status = $this->check_permission('view_cashbook');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $cashbook_model = new CashbookModel();
        $cashbook = $cashbook_model->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($cashbook as $r) {
            $data[] = array(
                $r['cashbook_id'],
                date($settings['date_format'], strtotime($r['create_date'])),
                $r['cashbook_description'],
                $r['in_amount'],
                $r['out_amount']
            );
        }
        $result = array(
            "recordsTotal" => $cashbook_model->countAll(),
            "recordsFiltered" => $cashbook_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    /* 004. Income */

    public function income()
    {
        $permission_status = $this->check_permission('view_income');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Income';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('account/income', $data);
        return view('dashboard/master', $data);
    }

    public function income_datatable()
    {
        $permission_status = $this->check_permission('view_income');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $income_model = new IncomeModel();
        $incomes = $income_model->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($incomes as $r) {
            $data[] = array(
                $r['income_id'],
                date($settings['date_format'], strtotime($r['create_date'])),
                $r['income_description'],
                $r['income_amount']
            );
        }
        $result = array(
            "recordsTotal" => $income_model->countAll(),
            "recordsFiltered" => $income_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    /* 005. Expense */

    public function expense()
    {
        $permission_status = $this->check_permission('view_expense');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Expense';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('account/expense', $data);
        return view('dashboard/master', $data);
    }

    public function expense_datatable()
    {
        $permission_status = $this->check_permission('view_expense');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $cashbook_model = new CashbookModel();
        $expenses = $cashbook_model->where('table_name', 'partners')->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($expenses as $r) {
            $data[] = array(
                $r['cashbook_id'],
                date($settings['date_format'], strtotime($r['create_date'])),
                $r['cashbook_description'],
                $r['out_amount']
            );
        }
        $result = array(
            "recordsTotal" => $cashbook_model->countAll(),
            "recordsFiltered" => $cashbook_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    /* 006. Invoice */

    public function invoice_download($invoice_id)
    {
        $cashbook_model = new CashbookModel();

        $settings = $this->data['settings'];

        $sale = $cashbook_model->query("SELECT table_name FROM sales WHERE sale_id = '$invoice_id'");
        $sale_info = $sale->getRowArray()['table_name'];

        if ($sale_info == 'domains') :
            $sql = "SELECT sales.sale_id, sales.invoice_id, sales.net_price, sales.discount_amount, sales.sale_due, sales.grand_total, users.first_name, users.last_name,
             users.user_email, sales.create_date, domains.expiry_date, domains.domain_name, sales.sale_description "
                . "FROM domains "
                . "LEFT JOIN sales ON (sales.fk_reference_id = domains.domain_id) "
                . "LEFT JOIN users ON (users.user_id = domains.fk_user_id) "
                . "WHERE sales.table_name = 'domains' AND sales.sale_id = '$invoice_id'";

            $invoice = $cashbook_model->query($sql);
            $invoice_info = $invoice->getRowArray();

            $total = $invoice_info['net_price'];
            $discount_amount = $invoice_info['discount_amount'];
            $grand_total = $invoice_info['grand_total'];

            $sql = "SELECT * "
                . "FROM transactions "
                . "WHERE transaction_type = 'sale' AND fk_reference_id = '" . $invoice_info['sale_id'] . "'";
            $transaction = $cashbook_model->query($sql);
            $transactions = $transaction->getResultArray();

            $pdf = new \FPDF();
            $pdf->AddPage('P', 'A4', 0);
            $pdf->AliasNbPages();

            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(59, 5, 'Evis Technology', 0, 0);
            $pdf->Cell(59, 5, '', 0, 0);
            $pdf->Cell(71, 5, 'Invoice ID: #' . $invoice_info['invoice_id'], 0, 1);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(118, 5, 'sales@evistechnology.com', 0, 0);
            $pdf->Cell(20, 5, 'Full Name:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['first_name'] . ' ' . $invoice_info['last_name'], 0, 1);

            $pdf->Cell(118, 5, 'Phone: +88 0963 8903899', 0, 0);
            $pdf->Cell(20, 5, 'Mobile:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['last_name'], 0, 1);

            $pdf->Cell(118, 5, '', 0, 0);
            $pdf->Cell(20, 5, 'Email:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['user_email'], 0, 1);
            $pdf->Ln(5);

            $pdf->Cell(30, 6, 'Start Date', 1);
            $pdf->Cell(30, 6, 'Expiry Date', 1);
            $pdf->Cell(45, 6, 'Domain Name', 1);
            $pdf->Cell(80, 6, 'Description', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);

            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['create_date'])), 1);
            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['expiry_date'])), 1);
            $pdf->Cell(45, 6, $invoice_info['domain_name'], 1);
            $pdf->Cell(80, 6, $invoice_info['sale_description'], 1);

            $pdf->SetFont('Arial', '', 9);
            $pdf->Ln(10);
            $pdf->Cell(125, 6, '', 0);
            $pdf->Cell(60, 6, 'Total - ' . $total . ' BDT', 1);
            $pdf->Ln(5);

            if ($discount_amount >= 1) :
                $pdf->Cell(125, 6, '', 0);
                $pdf->Cell(60, 6, 'Discount - ' . $discount_amount . ' BDT', 1);
                $pdf->Ln(5);

                $pdf->Cell(125, 6, '', 0);
                $pdf->Cell(60, 6, 'Grand Total - ' . $grand_total . ' BDT', 1);
                $pdf->Ln(5);
            endif;

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(125, 6, '', 0);
            $pdf->Cell(60, 6, 'Sale Due - ' . $invoice_info['sale_due'] . ' BDT', 1);
            $pdf->Ln(10);

            $pdf->Cell(125, 6, 'Transaction Date', 1);
            $pdf->Cell(60, 6, 'Paid Amount', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 9);

            foreach ($transactions as $value) :
                $pdf->Cell(125, 6, date($settings['date_format'], strtotime($value['transaction_date'])), 1);
                $pdf->Cell(60, 6, $value['paid_amount'] . ' BDT', 1);
                $pdf->Ln(5);
            endforeach;

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Ln(10);
            $pdf->Cell(185, 6, convert_number_to_words($grand_total) . ' Taka Only.', 1);
            $pdf->Ln(6);
            $pdf->Cell(185, 6, 'This is system generated invoice no signature is required.', 0);

            $response = service('response');
            $response->setHeader('Content-Type', 'application/pdf');

            $pdf->Output('domain_' . $invoice_info['invoice_id'] . '.pdf', 'I');

        elseif ($sale_info == 'hostings') :
            $sql = "SELECT sales.sale_id, sales.invoice_id, sales.net_price, sales.discount_amount, sales.grand_total, sales.sale_due,"
                . " users.first_name, users.last_name, users.user_email, users.user_mobile, sales.create_date, hostings.expiry_date, hostings.hosting_space, sales.sale_description "
                . "FROM hostings "
                . "LEFT JOIN sales ON (sales.fk_reference_id = hostings.hosting_id) "
                . "LEFT JOIN users ON (users.user_id = hostings.fk_user_id) "
                . "WHERE sales.table_name = 'hostings' AND sales.sale_id = '$invoice_id'";

            $invoice = $cashbook_model->query($sql);
            $invoice_info = $invoice->getRowArray();

            $total = $invoice_info['net_price'];
            $discount_amount = $invoice_info['discount_amount'];
            $grand_total = $invoice_info['grand_total'];

            $sql = "SELECT * "
                . "FROM transactions "
                . "WHERE transaction_type = 'sale' AND fk_reference_id = '" . $invoice_info['sale_id'] . "'";
            $transaction = $cashbook_model->query($sql);
            $transactions = $transaction->getResultArray();

            $pdf = new \FPDF();
            $pdf->AddPage('P', 'A4', 0);
            $pdf->AliasNbPages();

            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(59, 5, 'Evis Technology', 0, 0);
            $pdf->Cell(59, 5, '', 0, 0);
            $pdf->Cell(71, 5, 'Invoice ID: #' . $invoice_info['invoice_id'], 0, 1);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(118, 5, 'sales@evistechnology.com', 0, 0);
            $pdf->Cell(20, 5, 'Full Name:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['first_name'] . ' ' . $invoice_info['last_name'], 0, 1);

            $pdf->Cell(118, 5, 'Phone: +88 0963 8903899', 0, 0);
            $pdf->Cell(20, 5, 'Mobile:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['user_mobile'], 0, 1);

            $pdf->Cell(118, 5, '', 0, 0);
            $pdf->Cell(20, 5, 'Email:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['user_email'], 0, 1);
            $pdf->Ln(5);

            $pdf->Cell(30, 6, 'Start Date', 1);
            $pdf->Cell(30, 6, 'Expiry Date', 1);
            $pdf->Cell(25, 6, 'Hosting Space', 1);
            $pdf->Cell(100, 6, 'Description', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);

            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['create_date'])), 1);
            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['expiry_date'])), 1);
            $pdf->Cell(25, 6, $invoice_info['hosting_space'], 1);
            $pdf->Cell(100, 6, $invoice_info['sale_description'], 1);

            $pdf->SetFont('Arial', '', 9);
            $pdf->Ln(10);
            $pdf->Cell(125, 6, '', 0);
            $pdf->Cell(60, 6, 'Total - ' . $total . ' BDT', 1);
            $pdf->Ln(5);

            if ($discount_amount >= 1) :
                $pdf->Cell(125, 6, '', 0);
                $pdf->Cell(60, 6, 'Discount - ' . $discount_amount . ' BDT', 1);
                $pdf->Ln(5);

                $pdf->Cell(125, 6, '', 0);
                $pdf->Cell(60, 6, 'Grand Total - ' . $grand_total . ' BDT', 1);
                $pdf->Ln(5);
            endif;

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(125, 6, '', 0);
            $pdf->Cell(60, 6, 'Sale Due - ' . $invoice_info['sale_due'] . ' BDT', 1);
            $pdf->Ln(10);

            $pdf->Cell(125, 6, 'Transaction Date', 1);
            $pdf->Cell(60, 6, 'Paid Amount', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 9);

            foreach ($transactions as $value) :
                $pdf->Cell(125, 6, date($settings['date_format'], strtotime($value['transaction_date'])), 1);
                $pdf->Cell(60, 6, $value['paid_amount'] . ' BDT', 1);
                $pdf->Ln(5);
            endforeach;

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Ln(10);
            $pdf->Cell(185, 6, convert_number_to_words($grand_total) . ' Taka Only.', 1);
            $pdf->Ln(6);
            $pdf->Cell(185, 6, 'This is system generated invoice no signature is required.', 0);

            $response = service('response');
            $response->setHeader('Content-Type', 'application/pdf');

            $pdf->Output('hosting_' . $invoice_info['invoice_id'] . '.pdf', 'I');

        elseif ($sale_info == 'services') :
            $sql = "SELECT sales.sale_id, sales.invoice_id, sales.net_price, sales.discount_amount, sales.sale_due, sales.grand_total, users.first_name, users.last_name,"
                . " users.user_email, users.user_mobile, sales.create_date, services.expiry_date, sales.sale_description "
                . "FROM services "
                . "LEFT JOIN sales ON (sales.fk_reference_id = services.service_id) "
                . "LEFT JOIN users ON (users.user_id = services.fk_user_id) "
                . "WHERE sales.table_name = 'services' AND sales.sale_id = '$invoice_id'";

            $invoice = $cashbook_model->query($sql);
            $invoice_info = $invoice->getRowArray();

            $total = $invoice_info['net_price'];
            $discount_amount = $invoice_info['discount_amount'];
            $grand_total = $invoice_info['grand_total'];

            $sql = "SELECT * "
                . "FROM transactions "
                . "WHERE transaction_type = 'sale' AND fk_reference_id = '" . $invoice_info['sale_id'] . "'";
            $transaction = $cashbook_model->query($sql);
            $transactions = $transaction->getResultArray();

            $pdf = new \FPDF();
            $pdf->AddPage('P', 'A4', 0);
            $pdf->AliasNbPages();

            $pdf->SetFont('Arial', 'B', 15);
            $pdf->Cell(59, 5, 'Evis Technology', 0, 0);
            $pdf->Cell(59, 5, '', 0, 0);
            $pdf->Cell(71, 5, 'Invoice ID: #' . $invoice_info['invoice_id'], 0, 1);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(118, 5, 'sales@evistechnology.com', 0, 0);
            $pdf->Cell(20, 5, 'Full Name:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['first_name'] . ' ' . $invoice_info['last_name'], 0, 1);

            $pdf->Cell(118, 5, 'Phone: +88 0963 8903899', 0, 0);
            $pdf->Cell(20, 5, 'Mobile:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['user_mobile'], 0, 1);

            $pdf->Cell(118, 5, '', 0, 0);
            $pdf->Cell(20, 5, 'Email:', 0, 0);
            $pdf->Cell(34, 5, $invoice_info['user_email'], 0, 1);
            $pdf->Ln(5);

            $pdf->Cell(30, 6, 'Start Date', 1);
            $pdf->Cell(30, 6, 'Expiry Date', 1);
            $pdf->Cell(125, 6, 'Description', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);

            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['create_date'])), 1);
            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['expiry_date'])), 1);
            $pdf->Cell(125, 6, $invoice_info['sale_description'], 1);

            $pdf->SetFont('Arial', '', 9);
            $pdf->Ln(10);
            $pdf->Cell(125, 6, '', 0);
            $pdf->Cell(60, 6, 'Total - ' . $total . ' BDT', 1);
            $pdf->Ln(5);

            if ($discount_amount >= 1) :
                $pdf->Cell(125, 6, '', 0);
                $pdf->Cell(60, 6, 'Discount - ' . $discount_amount . ' BDT', 1);
                $pdf->Ln(5);

                $pdf->Cell(125, 6, '', 0);
                $pdf->Cell(60, 6, 'Grand Total - ' . $grand_total . ' BDT', 1);
                $pdf->Ln(5);
            endif;

            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(125, 6, '', 0);
            $pdf->Cell(60, 6, 'Sale Due - ' . $invoice_info['sale_due'] . ' BDT', 1);
            $pdf->Ln(10);

            $pdf->Cell(125, 6, 'Transaction Date', 1);
            $pdf->Cell(60, 6, 'Paid Amount', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 9);

            foreach ($transactions as $value) :
                $pdf->Cell(125, 6, date($settings['date_format'], strtotime($value['transaction_date'])), 1);
                $pdf->Cell(60, 6, $value['paid_amount'] . ' BDT', 1);
                $pdf->Ln(5);
            endforeach;

            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Ln(10);
            $pdf->Cell(185, 6, convert_number_to_words($grand_total) . ' Taka Only.', 1);
            $pdf->Ln(6);
            $pdf->Cell(185, 6, 'This is system generated invoice no signature is required.', 0);

            $response = service('response');
            $response->setHeader('Content-Type', 'application/pdf');

            $pdf->Output('service_' . $invoice_info['invoice_id'] . '.pdf', 'I');
        endif;
    }
}
