<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Client extends BaseController
{
    /**
     * Resources
     * 001. Client Area
     * 002. Domain
     * 003. Hosting
     * 004. Projects
     * 005. Tickets
     * 006. Invoices
     * 007. Profile Info
     */
    /* 001. Client Area */

    public function index()
    {
        $user_id = $this->session->get('user_id');
        $user_name = $this->session->get('user_name');

        $ticket_model = new TicketModel();

        $domain = $ticket_model->query("SELECT COUNT(domain_id) AS total_domains FROM domains WHERE domain_status = 'active' AND fk_user_id = '$user_id'");
        $domain_stat = $domain->getRowArray();

        $hosting = $ticket_model->query("SELECT COUNT(hosting_id) AS total_hostings FROM hostings WHERE hosting_status = 'active' AND fk_user_id = '$user_id'");
        $hosting_stat = $hosting->getRowArray();

        $project = $ticket_model->query("SELECT COUNT(service_id) AS total_projects FROM services WHERE service_status = 'active' AND fk_user_id = '$user_id'");
        $project_stat = $project->getRowArray();

        $ticket = $ticket_model->query("SELECT COUNT(ticket_id) AS total_tickets FROM tickets WHERE service_name IS NOT NULL AND fk_user_id = '$user_id'");
        $ticket_stat = $ticket->getRowArray();

        $invoice = $ticket_model->query("SELECT COUNT(sale_id) AS total_invoices FROM sales WHERE sale_status = 'active' AND fk_user_id = '$user_id'");
        $invoice_stat = $invoice->getRowArray();

        $data = array();
        $data['user_name'] = $user_name;
        $data['domains'] = $domain_stat;
        $data['hostings'] = $hosting_stat;
        $data['projects'] = $project_stat;
        $data['tickets'] = $ticket_stat;
        $data['invoices'] = $invoice_stat;

        $data['opened_ticket'] = $ticket_model->where('fk_user_id', $user_id)->where('ticket_status', 'open')->orderBy('ticket_id', 'DESC')->first();

        if ($data['opened_ticket']) :
            $ticket_id = $data['opened_ticket']['fk_ticket_id'];
            $data['admin_reply'] = $ticket_model
                ->where('fk_ticket_id', $ticket_id)
                ->where('ticket_status', 'open')
                ->where('fk_admin_id !=', NULL)
                ->orderBy('ticket_id', 'DESC')
                ->first();
        endif;

        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/client_area', $data);
        return view('website/master', $data);
    }

    /* 002. Domain */

    public function domain()
    {
        $ticket_model = new TicketModel();

        $domain = $ticket_model->query("SELECT domain_name, expiry_date FROM domains WHERE domain_status = 'active' AND fk_user_id = '" . $this->session->get('user_id') . "'");
        $domains = $domain->getResultArray();

        $data = array();
        $data['domains'] = $domains;
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/domain', $data);
        return view('website/master', $data);
    }

    /* 003. Hosting */

    public function hosting()
    {
        $ticket_model = new TicketModel();

        $hosting = $ticket_model->query("SELECT hosting_space, primary_domain, expiry_date, cpanel_url, email_url FROM hostings WHERE hosting_status = 'active' AND fk_user_id = '" . $this->session->get('user_id') . "'");
        $hostings = $hosting->getResultArray();

        $data = array();
        $data['hostings'] = $hostings;
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/hosting', $data);
        return view('website/master', $data);
    }

    /* 004. Projects */

    public function projects()
    {
        $ticket_model = new TicketModel();

        $project = $ticket_model->query("SELECT service_name, service_url, expiry_date FROM services WHERE service_status = 'active' AND fk_user_id = '" . $this->session->get('user_id') . "'");
        $projects = $project->getResultArray();

        $data = array();
        $data['projects'] = $projects;
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/projects', $data);
        return view('website/master', $data);
    }

    /* 005. Tickets */

    public function tickets()
    {
        $user_id = $this->session->get('user_id');
        $ticket_model = new TicketModel();

        $domain = $ticket_model->query("SELECT domain_name, expiry_date FROM domains WHERE domain_status = 'active' AND fk_user_id = '$user_id'");
        $domains = $domain->getResultArray();

        $hosting = $ticket_model->query("SELECT hosting_space, primary_domain, expiry_date, cpanel_url, email_url FROM hostings WHERE hosting_status = 'active' AND fk_user_id = '$user_id'");
        $hostings = $hosting->getResultArray();

        $service = $ticket_model->query("SELECT service_name FROM services WHERE service_status = 'active' AND fk_user_id = '$user_id'");
        $services = $service->getResultArray();

        $data = array();

        $data['opened_ticket'] = $ticket_model->where('fk_user_id', $user_id)->where('ticket_status', 'open')->orderBy('ticket_id', 'DESC')->first();

        if ($data['opened_ticket']) :
            $ticket_id = $data['opened_ticket']['fk_ticket_id'];
            $data['admin_reply'] = $ticket_model
                ->where('fk_ticket_id', $ticket_id)
                ->where('ticket_status', 'open')
                ->where('fk_admin_id !=', NULL)
                ->orderBy('ticket_id', 'DESC')
                ->first();
        endif;

        $data['tickets'] = $ticket_model->where('service_name IS NOT NULL', NULL, FALSE)->where('fk_user_id', $user_id)->orderBy('ticket_id', 'DESC')->findAll();
        $data['domains'] = $domains;
        $data['hostings'] = $hostings;
        $data['services'] = $services;
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/tickets', $data);
        return view('website/master', $data);
    }

    public function save_ticket()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'service_name' => [
                'label' => 'Service Name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Select The Service Name.'
                ]
            ],
            'ticket_content' => [
                'label' => 'Problem Description',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Discribe Your Problem.'
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $user_id = $this->session->get('user_id');
            $user_name = $this->session->get('user_name');
            $service_name = $this->request->getPost('service_name');
            $ticket_content = $this->request->getPost('ticket_content');

            $message = "A New Ticket Has Been Created. Customer Name: $user_name. Service Name: $service_name, Wrote His Problem: $ticket_content";

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'New Ticket Created',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            /* Send Email */

            $ticket_model = new TicketModel();

            $user_info = $ticket_model->query("SELECT user_email FROM users WHERE user_id = '$user_id'");
            $user_email = $user_info->getRowArray();

            $email = \Config\Services::email();
            $email->setFrom($user_email['user_email'], ' From ' . $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject($this->data['settings']['project_name'] . ' New Support Ticket');
            $email->setMessage($message);
            $email->send();

            $db = \Config\Database::connect();
            $builder = $db->table('tickets');

            $data = [
                'fk_user_id' => $user_id,
                'service_name' => $service_name,
                'ticket_content' => $ticket_content,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $user_id
            ];
            $builder->insert($data);

            echo 'success';
            exit();
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    public function ticket_reply($ticket_id)
    {
        $user_id = $this->session->get('user_id');
        $user_name = $this->session->get('user_name');
        $ticket_model = new TicketModel();
        $data = array();
        $data['user_name'] = $user_name;
        $data['ticket_info'] = $ticket_model->where('fk_user_id', $user_id)->find($ticket_id);
        $data['ticket_replies'] = $ticket_model->where('fk_ticket_id', $ticket_id)->findAll();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/ticket_reply', $data);
        return view('website/master', $data);
    }

    public function update_reply()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'reply' => [
                'label' => 'Customer Reply',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Write Your Reply.'
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $user_id = $this->session->get('user_id');
            $user_name = $this->session->get('user_name');
            $ticket_id = $this->request->getPost('ticket_id');
            $service_name = $this->request->getPost('service_name');
            $ticket_reply = $this->request->getPost('reply');

            $message = "Ticket Replied. Customer Name: $user_name. Service Name: $service_name, Reply: $ticket_reply";

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'Ticket Replied',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            /* Send Email */

            $ticket_model = new TicketModel();

            $user_info = $ticket_model->query("SELECT user_email FROM users WHERE user_id = '$user_id'");
            $user_email = $user_info->getRowArray();

            $email = \Config\Services::email();
            $email->setFrom($user_email['user_email'], ' From ' . $this->data['settings']['project_name']);
            $email->setTo($this->data['settings']['contact_email']);
            $email->setSubject($this->data['settings']['project_name'] . ' Ticket Replied');
            $email->setMessage($message);
            $email->send();

            $db = \Config\Database::connect();
            $builder = $db->table('tickets');

            $data = [
                'fk_ticket_id' => $ticket_id,
                'fk_user_id' => $user_id,
                'ticket_content' => $ticket_reply,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $user_id
            ];
            $builder->insert($data);

            echo 'success';
            exit();
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }

    /* 006. Invoices */

    public function invoices()
    {
        $ticket_model = new TicketModel();

        $invoice = $ticket_model->query("SELECT sale_id, sale_description, due_date FROM sales WHERE sale_status = 'active' AND fk_user_id = '" . $this->session->get('user_id') . "'");
        $invoices = $invoice->getResultArray();

        $data = array();
        $data['invoices'] = $invoices;
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/invoices', $data);
        return view('website/master', $data);
    }

    public function invoice_download($invoice_id)
    {
        $ticket_model = new TicketModel();

        $settings = $this->data['settings'];

        $sale = $ticket_model->query("SELECT table_name FROM sales WHERE sale_id = '$invoice_id'");
        $sale_info = $sale->getRowArray()['table_name'];

        if ($sale_info == 'domains') :
            $sql = "SELECT * "
                . "FROM domains AS d "
                . "LEFT JOIN sales AS s ON (s.fk_reference_id = d.domain_id) "
                . "LEFT JOIN users AS u ON (u.user_id = d.fk_user_id) "
                . "WHERE s.table_name = 'domains' AND s.sale_id = '$invoice_id'";

            $invoice = $ticket_model->query($sql);
            $invoice_info = $invoice->getRowArray();

            $total = $invoice_info['net_price'];
            $discount_amount = $invoice_info['discount_amount'];
            $grand_total = $invoice_info['grand_total'];

            $sql = "SELECT * "
                . "FROM transactions "
                . "WHERE transaction_type = 'sale' AND fk_reference_id = '" . $invoice_info['sale_id'] . "'";
            $transaction = $ticket_model->query($sql);
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
            $pdf->Cell(45, 6, 'Domain Name', 1);
            $pdf->Cell(80, 6, 'Description', 1);

            $pdf->Ln(5);
            $pdf->SetFont('Arial', '', 8);

            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['renew_date'])), 1);
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

            $pdf->Output('Invoice_ID_' . $invoice_info['invoice_id'] . '.pdf', 'I');

        elseif ($sale_info == 'hostings') :
            $sql = "SELECT * "
                . "FROM hostings AS h "
                . "LEFT JOIN sales AS s ON (s.fk_reference_id = h.hosting_id) "
                . "LEFT JOIN users AS u ON (u.user_id = h.fk_user_id) "
                . "WHERE s.table_name = 'hostings' AND s.sale_id = '$invoice_id'";

            $invoice = $ticket_model->query($sql);
            $invoice_info = $invoice->getRowArray();

            $total = $invoice_info['net_price'];
            $discount_amount = $invoice_info['discount_amount'];
            $grand_total = $invoice_info['grand_total'];

            $sql = "SELECT * "
                . "FROM transactions "
                . "WHERE transaction_type = 'sale' AND fk_reference_id = '" . $invoice_info['sale_id'] . "'";
            $transaction = $ticket_model->query($sql);
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

            $pdf->Cell(30, 6, date($settings['date_format'], strtotime($invoice_info['renew_date'])), 1);
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

            $pdf->Output('Invoice_ID_' . $invoice_info['invoice_id'] . '.pdf', 'I');

        elseif ($sale_info == 'services') :
            $sql = "SELECT * "
                . "FROM services AS h "
                . "LEFT JOIN sales AS s ON (s.fk_reference_id = h.service_id) "
                . "LEFT JOIN users AS u ON (u.user_id = h.fk_user_id) "
                . "WHERE s.table_name = 'services' AND s.sale_id = '$invoice_id'";

            $invoice = $ticket_model->query($sql);
            $invoice_info = $invoice->getRowArray();

            $total = $invoice_info['net_price'];
            $discount_amount = $invoice_info['discount_amount'];
            $grand_total = $invoice_info['grand_total'];

            $sql = "SELECT * "
                . "FROM transactions "
                . "WHERE transaction_type = 'sale' AND fk_reference_id = '" . $invoice_info['sale_id'] . "'";
            $transaction = $ticket_model->query($sql);
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

            $pdf->Output('Invoice_ID_' . $invoice_info['invoice_id'] . '.pdf', 'I');
        endif;
    }

    /* 007. Profile Info */

    public function user_info()
    {
        $data = array();
        $data['settings'] = $this->data['settings'];
        $data['content'] = view('website/client_area/user_info', $data);
        return view('website/master', $data);
    }

    public function update_userinfo()
    {
        helper(['form']);
        $validation = \Config\Services::validation();
        $rules = [
            'current_password' => [
                'label' => 'Current Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter Your Current Password.',
                ],
            ],
            'new_password' => [
                'label' => 'New Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please Enter New Password.'
                ]
            ],
            'confirm_password' => [
                'label' => 'Confirm Password',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Please Enter Confirm Password.'
                ]
            ],
        ];

        $ticket_model = new TicketModel();

        $user_id = $this->session->get('user_id');
        $user = $ticket_model->query("SELECT * FROM users WHERE user_id = '$user_id'");
        $user_info = $user->getRowArray();

        if ($this->validate($rules)) {
            $db = \Config\Database::connect();
            $builder = $db->table('users');

            $new_password = $this->request->getPost('new_password');

            $message =  $user_info['first_name'] . ' ' . $user_info['last_name'] .  ' Has Changed Password. User ID -' . $user_id;

            /* Send Notification */

            $db = \Config\Database::connect();
            $builder = $db->table('notifications');

            $data = [
                'notification_title' => 'User Password Changed',
                'notification' => $message,
                'create_time' => current_time(),
                'create_date' => current_date(),
                'created_by' => $this->session->get('user_id')
            ];

            $builder->insert($data);

            $data = [
                'user_password' => $new_password,
                'modify_time' => current_time(),
                'modify_date' => current_date(),
                'modified_by' => $user_id
            ];

            $builder->where('user_id', $user_id);
            $builder->update($data);

            echo 'success';
            exit();
        } else {
            $validation = $validation->getErrors();
            $errorMessage = implode('<br>', $validation);
            echo $errorMessage;
            exit();
        }
    }
}
