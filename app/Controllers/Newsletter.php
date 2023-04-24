<?php

namespace App\Controllers;

use App\Models\NewsletterModel;

class Newsletter extends BaseController
{
    public function index()
    {
        $permission_status = $this->check_permission('view_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Newsletter';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('newsletter/newsletters', $data);
        return view('dashboard/master', $data);
    }

    public function newsletter_datatable()
    {
        $permission_status = $this->check_permission('view_ticket');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $newsletter_model = new NewsletterModel();
        $newsletter = $newsletter_model
            ->orderBy('newsletter_id', 'DESC')
            ->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($newsletter as $r) {
            $data[] = array(
                $r['newsletter_id'],
                $r['newsletter_email'],
                date($settings['date_format'], strtotime($r['create_date'])),
                date($settings['time_format'], strtotime($r['create_time'])),
                '<a href="javascript:;" data-toggle="modal" data-target="#staticBackdrop" class="theFile btn btn-danger btn-xs" data-id="' . $r['newsletter_id'] . '">Delete</a>'
            );
        }
        $result = array(
            "recordsTotal" => $newsletter_model->countAll(),
            "recordsFiltered" => $newsletter_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function confirmDeleteNewsletter($newsletter_id)
    {
        $data = array();
        $data['newsletter_id'] = $newsletter_id;
        return view('newsletter/confirmDeleteNewsletter', $data);
    }

    public function delete_newsletter($newsletter_id)
    {
        $newsletter_model = new NewsletterModel();
        $newsletter_model->where('newsletter_id', $newsletter_id)->delete();
        return redirect()->to('/newsletter');
    }
}
