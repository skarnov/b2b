<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\ActivityModel;

class Ticket extends BaseController
{
    /**
     * Resources
     * 001. Ticket
     */
    /* 001. Ticket */

    public function index()
    {
        $permission_status = $this->check_permission('view_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Tickets';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('crm/tickets', $data);
        return view('dashboard/master', $data);
    }

    public function ticket_datatable()
    {
        $permission_status = $this->check_permission('view_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $ticket_model = new TicketModel();
        $tickets = $ticket_model
            ->select('tickets.ticket_id, tickets.create_date, users.first_name, users.last_name, tickets.service_name, tickets.ticket_content, tickets.ticket_status')
            ->join('users', 'users.user_id = tickets.fk_user_id', 'left')
            ->where("tickets.service_name != 'NULL'")
            ->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($tickets as $r) {
            $data[] = array(
                $r['ticket_id'],
                date($settings['date_format'], strtotime($r['create_date'])),
                $r['first_name'],
                $r['last_name'],
                $r['service_name'],
                $r['ticket_content'],
                ($r['ticket_status'] == 'closed') ? "<span class='badge badge-success'>Closed</span>" : "<span class='badge badge-danger'>Open</span>",
                '<a class="btn btn-primary btn-xs" href="' . base_url() . '/ticket/edit_ticket/' . $r['ticket_id'] . '">Reply</a>'
            );
        }
        $result = array(
            "recordsTotal" => $ticket_model->countAll(),
            "recordsFiltered" => $ticket_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function edit_ticket($ticket_id)
    {
        $permission_status = $this->check_permission('reply_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $ticket_model = new TicketModel();

        $data = array();
        $data['title'] = 'Ticket Reply';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['ticket_info'] = $ticket_model->where('ticket_id', $ticket_id)->first();
        $data['ticket_replies'] = $ticket_model->where('fk_ticket_id', $ticket_id)->find();
        $data['home'] = view('crm/edit_ticket', $data);
        return view('dashboard/master', $data);
    }

    public function update_ticket()
    {
        $permission_status = $this->check_permission('reply_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $ticket_model = new TicketModel();
        $activity_model = new ActivityModel();

        $admin_id = $this->session->get('admin_id');
        $status = $this->request->getPost('status');

        if ($status == 'closed') :
            $data = array();
            $data['ticket_status'] = $status;
            $data['modify_time'] = current_time();
            $data['modify_date'] = current_date();
            $data['modified_by'] = $admin_id;

            try {
                $ticket_model
                    ->where('fk_ticket_id', $this->request->getPost('ticket_id'))
                    ->set($data)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        endif;
        
        if ($status == 'open') :
            $data = array();
            $data['ticket_status'] = $status;
            $data['modify_time'] = current_time();
            $data['modify_date'] = current_date();
            $data['modified_by'] = $admin_id;

            try {
                $ticket_model
                    ->where('fk_ticket_id', $this->request->getPost('ticket_id'))
                    ->set($data)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        endif;

        $data = array();
        $data['fk_admin_id'] = $this->session->get('admin_id');
        $data['service_name'] = $this->request->getPost('service_name');
        $data['ticket_status'] = $status;
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $ticket_model
                ->where('ticket_id', $this->request->getPost('ticket_id'))
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $ticket_reply = $this->request->getPost('reply');

        if ($ticket_reply) :
            $reply = array();
            $reply['fk_ticket_id'] = $this->request->getPost('ticket_id');
            $reply['fk_admin_id'] = $this->session->get('admin_id');
            $reply['ticket_content'] = $ticket_reply;
            $reply['ticket_status'] = $status;
            $reply['create_time'] = current_time();
            $reply['create_date'] = current_date();
            $reply['created_by'] = $admin_id;

            try {
                $ticket_model->insert($reply);
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        endif;

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_user_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Admin Ticket Replied - Service Name ' . $data['service_name'];
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
