<?php

namespace App\Controllers;

use App\Models\MessageModel;

class Message extends BaseController
{
    public function index()
    {
        $permission_status = $this->check_permission('view_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Messages';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');

        $data['home'] = view('message/messages', $data);
        return view('dashboard/master', $data);
    }

    public function messages_datatable()
    {
        $permission_status = $this->check_permission('view_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $message_model = new MessageModel();
        $message = $message_model
            ->orderBy('message_id', 'DESC')
            ->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($message as $r) {
            $data[] = array(
                $r['message_id'],
                $r['email'],
                $r['name'],
                $r['message'],
                date($settings['date_format'], strtotime($r['create_date'])),
                date($settings['time_format'], strtotime($r['create_time'])),
                '<a href="javascript:;" data-toggle="modal" data-target="#staticBackdrop" class="theFile btn btn-danger btn-xs" data-id="'.$r['message_id'].'">Delete</a>'
            );
        }
        $result = array(
            "recordsTotal" => $message_model->countAll(),
            "recordsFiltered" => $message_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function confirmDeleteMessage($message_id)
    {
        $data = array();
        $data['message_id'] = $message_id;
        return view('message/confirmDeleteMessage', $data);
    }

    public function delete_message($message_id)
    {
        $message_model = new MessageModel();
        $message_model->where('message_id', $message_id)->delete();
        return redirect()->to('/message');
    }
}
