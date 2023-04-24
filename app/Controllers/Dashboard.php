<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\ActivityModel;
use App\Models\ConfigModel;
use App\Models\NotificationModel;
use App\Models\RoleModel;
use App\Models\PermissionModel;

class Dashboard extends BaseController
{
    /**
     * Resources
     * 001. Dashboard
     * 002. Profile
     * 003. Activities
     * 004. Notifications
     * 005. Role Permission
     * 006. Maintenance
     * 007. Admins
     * 008. Settings
     */
    /* 001. Dashboard */

    public function index()
    {
        $admin_model = new AdminModel();

        $first_day_this_month = date('Y-m-01');
        $last_day_this_month = date('Y-m-t');

        $cash_in = $admin_model->query('SELECT SUM(in_amount) AS in_amount FROM cashbook');
        $cash_in_stat = $cash_in->getRowArray()['in_amount'];

        $cash_out = $admin_model->query('SELECT SUM(out_amount) AS out_amount FROM cashbook');
        $cash_out_stat = $cash_out->getRowArray()['out_amount'];

        $new_user = $admin_model->query("SELECT COUNT(user_id) AS new_user FROM users WHERE user_status = 'inactive'");
        $new_user_stat = $new_user->getRowArray()['new_user'];

        $active_user = $admin_model->query("SELECT COUNT(user_id) AS active_user FROM users WHERE user_status = 'active'");
        $active_user_stat = $active_user->getRowArray()['active_user'];

        $user_this_month = $admin_model->query("SELECT COUNT(user_id) AS this_month_user FROM users WHERE create_date BETWEEN '$first_day_this_month' AND '$last_day_this_month' AND user_status = 'active'");
        $user_this_month_stat = $user_this_month->getRowArray()['this_month_user'];

        $ticket = $admin_model->query("SELECT COUNT(ticket_id) AS open_ticket FROM tickets WHERE ticket_status = 'open'");
        $ticket_stat = $ticket->getRowArray()['open_ticket'];

        $total_income = $admin_model->query("SELECT SUM(income_amount) AS total_income FROM incomes");
        $total_income_stat = $total_income->getRowArray()['total_income'];

        $income_this_month = $admin_model->query("SELECT SUM(income_amount) AS total_income FROM incomes WHERE create_date BETWEEN '$first_day_this_month' AND '$last_day_this_month'");
        $income_this_month_stat = $income_this_month->getRowArray()['total_income'];

        $active_domain = $admin_model->query("SELECT COUNT(domain_id) AS total_domain FROM domains WHERE domain_status = 'active'");
        $domain_stat = $active_domain->getRowArray()['total_domain'];

        $domain_sql = $admin_model->query("SELECT domain_id, expiry_date FROM domains WHERE domain_status = 'active'");
        $all_domains = $domain_sql->getResultArray();

        $expired_domains = array();
        $domain_count = 0;
        foreach ($all_domains as $value) {
            $expiry_date = date_create($value['expiry_date']);
            date_sub($expiry_date, date_interval_create_from_date_string('90 days'));
            $expiry = date_format($expiry_date, 'Y-m-d');
            $today = date('Y-m-d');
            if ($today > $expiry) {
                /* Domain Count */
                $expire = $admin_model->query("SELECT COUNT(domain_id) AS warning_domain FROM domains WHERE domain_id = '" . $value['domain_id'] . "'");
                $domains[] = $expire->getRowArray()['warning_domain'];
                $domain_count = array_count_values($domains)[1];
                /* Expired Domains */
                $expired_domain = $admin_model->query("SELECT domain_id, domain_name, expiry_date FROM domains WHERE domain_id = '" . $value['domain_id'] . "'");
                $expired_domains[] = $expired_domain->getRowArray();
            }
        }

        $active_hosting = $admin_model->query("SELECT COUNT(hosting_id) AS total_hosting FROM hostings WHERE hosting_status = 'active'");
        $hosting_stat = $active_hosting->getRowArray()['total_hosting'];

        $hosting_sql = $admin_model->query("SELECT hosting_id, expiry_date FROM hostings WHERE hosting_status = 'active'");
        $all_hostings = $hosting_sql->getResultArray();

        $expired_hostings = array();
        $hosting_count = 0;
        foreach ($all_hostings as $value) {
            $expiry_date = date_create($value['expiry_date']);
            date_sub($expiry_date, date_interval_create_from_date_string('90 days'));
            $expiry = date_format($expiry_date, 'Y-m-d');
            $today = date('Y-m-d');
            if ($today > $expiry) {
                /* Hosting Count */
                $expire = $admin_model->query("SELECT COUNT(hosting_id) AS warning_hosting FROM hostings WHERE hosting_id = '" . $value['hosting_id'] . "'");
                $hostings[] = $expire->getRowArray()['warning_hosting'];
                $hosting_count = array_count_values($hostings)[1];
                /* Expired Hostings */
                $expired_hosting = $admin_model->query("SELECT hosting_id, primary_domain, hosting_space, expiry_date FROM hostings WHERE hosting_id = '" . $value['hosting_id'] . "'");
                $expired_hostings[] = $expired_hosting->getRowArray();
            }
        }

        $data = array();
        $data['title'] = 'Evis Dashboard';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['cash_in_stat'] = $cash_in_stat;
        $data['cash_out_stat'] = $cash_out_stat;
        $data['new_user_stat'] = $new_user_stat;
        $data['active_user_stat'] = $active_user_stat;
        $data['user_this_month_stat'] = $user_this_month_stat;
        $data['ticket_stat'] = $ticket_stat;
        $data['total_income_stat'] = $total_income_stat;
        $data['income_this_month_stat'] = $income_this_month_stat;
        $data['domain_stat'] = $domain_stat;
        $data['domain_warning'] = $domain_count;
        $data['expired_domains'] = $expired_domains;
        $data['hosting_stat'] = $hosting_stat;
        $data['hosting_warning'] = $hosting_count;
        $data['expired_hostings'] = $expired_hostings;
        $data['home'] = view('dashboard/home', $data);
        return view('dashboard/master', $data);
    }

    /* 002. Profile */

    public function profile()
    {
        $permission_status = $this->check_permission('view_profile');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $admin_model = new AdminModel();

        $data = array();
        $data['title'] = 'Profile';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['admin_info'] = $admin_model->where('admin_id', $this->session->get('admin_id'))->first();
        $data['home'] = view('dashboard/profile', $data);
        return view('dashboard/master', $data);
    }

    public function update_profile()
    {
        $permission_status = $this->check_permission('edit_profile');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $admin_model = new AdminModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        $data = array();
        $data['first_name'] = $this->request->getPost('first_name');
        $data['last_name'] = $this->request->getPost('last_name');
        $data['admin_mobile'] = $this->request->getPost('admin_mobile');
        $data['admin_email'] = $this->request->getPost('admin_email');
        $data['user_name'] = $this->request->getPost('user_name');
        $data['admin_password'] = $this->request->getPost('admin_password');

        if ($this->request->getFile('image')) :
            @unlink('../public/uploads/profile_image/' . $this->request->getPost('previous_image'));
            $img = $this->request->getFile('image');
            $img->move(WRITEPATH . '../public/uploads/profile_image/');
            $data['admin_image'] = $img->getName();
        endif;

        $data['admin_sex'] = $this->request->getPost('sex');
        $data['admin_address'] = $this->request->getPost('admin_address');
        $data['admin_status'] = $this->request->getPost('status');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $admin_id;

        try {
            $admin_model
                ->where('admin_id', $admin_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die("<div class='alert alert-danger'>" . $e->getMessage() . "</div>");
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'Admin Updated - ' . $admin_id;
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

        echo "<div class='alert alert-primary'>Profile Updated</div>";
        exit();
    }

    /* 003. Activities */

    public function manage_activities()
    {
        $permission_status = $this->check_permission('view_activity');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Activities';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/activities', $data);
        return view('dashboard/master', $data);
    }

    public function activity_datatable()
    {
        $permission_status = $this->check_permission('view_activity');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $activity_model = new ActivityModel();
        $activities = $activity_model
            ->select('activities.activity_id, admins.user_name, activities.activity_type, activities.activity_name, activities.ip_address, activities.visitor_country, activities.visitor_state, activities.visitor_address, activities.create_time, activities.create_date')
            ->join('admins', 'admins.admin_id = activities.fk_admin_id')
            ->find();

        $settings = $this->data['settings'];

        $data = [];
        foreach ($activities as $r) {
            $data[] = array(
                $r['activity_id'],
                ucfirst($r['user_name']),
                ucfirst($r['activity_type']),
                ucfirst($r['activity_name']),
                $r['ip_address'],
                $r['visitor_country'],
                $r['visitor_state'],
                $r['visitor_address'],
                date($settings['time_format'], strtotime($r['create_time'])),
                date($settings['date_format'], strtotime($r['create_date'])),
            );
        }
        $result = array(
            "recordsTotal" => $activity_model->countAll(),
            "recordsFiltered" => $activity_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    /* 004. Notifications */

    public function manage_notifications()
    {
        $permission_status = $this->check_permission('view_notification');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Notifications';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/notifications', $data);
        return view('dashboard/master', $data);
    }

    public function notification_datatable()
    {
        $permission_status = $this->check_permission('view_notification');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $notification_model = new NotificationModel();
        $notifications = $notification_model->find();
        $settings = $this->data['settings'];

        $data = [];
        foreach ($notifications as $r) {
            $data[] = array(
                $r['notification_id'],
                date($settings['date_format'], strtotime($r['create_date'])) . ' ' . date($settings['time_format'], strtotime($r['create_time'])),
                $r['notification_title'],
                $r['notification'],
                ($r['view_status'] == 'seen') ? "<span class='badge badge-success'>Seen</span>" : "<span class='badge badge-primary'>Unseen</span>",
                '<div class="form-group">'
                    . '<a class="btn btn-success btn-xs" href="' . base_url() . '/dashboard/view_notification/' . $r['notification_id'] . '" title="Mark As Seen"><i class="fa fa-eye" area-hidden="true"></i></a>'
                    . '<a class="btn btn-danger btn-xs" href="' . base_url() . '/dashboard/delete_notification/' . $r['notification_id'] . '"><i class="fa fa-trash" area-hidden="true"></i></a>'
                    . '</div>'
            );
        }
        $result = array(
            "recordsTotal" => $notification_model->countAll(),
            "recordsFiltered" => $notification_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function view_notification($notification_id)
    {
        $permission_status = $this->check_permission('view_notification');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $notification_model = new NotificationModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        try {
            $notification_model
                ->where('notification_id', $notification_id)
                ->set('view_status', 'seen')
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Update Notification Start */
        $unseen_notifications = $notification_model->query("SELECT * FROM notifications WHERE view_status = 'unseen' ORDER BY notification_id DESC")->getResultArray();
        $total_notifications = $notification_model->query("SELECT COUNT(notification_id) AS total_notification FROM notifications WHERE view_status = 'unseen'")->getRowArray()['total_notification'];

        $sdata = [
            'notifications' => $unseen_notifications,
            'total_notifications' => $total_notifications,
        ];
        $this->session->set($sdata);
        /* Update Notification End */

        $notification_info = $notification_model->where('notification_id', $notification_id)->first();

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Notification Viewed - ' . $notification_id;
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

        $notification_link = $notification_info['notification_link'] ? $notification_info['notification_link'] : base_url() . '/dashboard/manage_notifications';
        return redirect()->to($notification_link);
    }

    public function delete_notification($notification_id)
    {
        $permission_status = $this->check_permission('delete_notification');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $notification_model = new NotificationModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        $notification_info = $notification_model->where('notification_id', $notification_id)->first();

        try {
            $notification_model
                ->where('notification_id', $notification_id)
                ->delete();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'Notification Deleted - ' . $notification_info['notification'];
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

        return redirect()->back();
    }

    /* 005. Role Permission */

    public function roles_permissions()
    {
        $permission_status = $this->check_permission('view_role');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $role_model = new RoleModel();

        $data = array();
        $data['title'] = 'Role & Permission';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_roles'] = $role_model->find();
        $data['home'] = view('dashboard/roles_permissions', $data);
        return view('dashboard/master', $data);
    }

    public function add_role()
    {
        $permission_status = $this->check_permission('add_role');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Add Role';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/add_role', $data);
        return view('dashboard/master', $data);
    }

    public function save_role()
    {
        $permission_status = $this->check_permission('add_role');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $role_model = new RoleModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        $data = array();
        $data['role_name'] = $this->request->getPost('name');
        $data['role_description'] = $this->request->getPost('description');
        $data['role_status'] = $this->request->getPost('status');
        $data['create_time'] = current_time();
        $data['create_date'] = current_date();
        $data['created_by'] = $this->session->get('admin_id');

        try {
            $role_model->insert($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $fk_role_id = $role_model->getInsertID();

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Role Created - ' . $fk_role_id;
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

    public function edit_role($role_id)
    {
        $permission_status = $this->check_permission('edit_role');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $role_model = new RoleModel();

        $data = array();
        $data['title'] = 'Edit Role';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['role_info'] = $role_model->where('role_id', $role_id)->first();
        $data['home'] = view('dashboard/edit_role', $data);
        return view('dashboard/master', $data);
    }

    public function update_role()
    {
        $permission_status = $this->check_permission('edit_role');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $role_model = new RoleModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');
        $role_id = $this->request->getPost('role_id');

        $data = array();
        $data['role_name'] = $this->request->getPost('name');
        $data['role_description'] = $this->request->getPost('description');
        $data['role_status'] = $this->request->getPost('status');
        $data['modify_time'] = current_time();
        $data['modify_date'] = current_date();
        $data['modified_by'] = $this->session->get('admin_id');

        try {
            $role_model
                ->where('role_id', $role_id)
                ->set($data)
                ->update();
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'Role Updated - ' . $role_id;
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

    public function edit_permission($role_id)
    {
        $permission_status = $this->check_permission('edit_permission');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $permission_model = new PermissionModel();

        $data = array();
        $data['role_id'] = $role_id;
        $data['title'] = 'Edit Permission';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['all_permissions'] = $permission_model->where('fk_role_id', $role_id)->find();
        $data['home'] = view('dashboard/edit_permission', $data);
        return view('dashboard/master', $data);
    }

    public function update_permission($role_id, $permission_name)
    {
        $permission_status = $this->check_permission('edit_permission');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $permission_model = new PermissionModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');
        $permission_exists = $permission_model->where('fk_role_id', $role_id)->where('permission_name', $permission_name)->first();

        if ($permission_exists) :
            echo $permission_exists['permission_name'] . ' Already Exists.';
            exit();
        else :
            $data = array();
            $data['fk_role_id'] = $role_id;
            $data['permission_name'] = $permission_name;

            try {
                $permission_model->insert($data);
            } catch (\Exception $e) {
                die($e->getMessage());
            }

            /* Activity Insert Start */

            $activity = array();
            $activity['fk_admin_id'] = $admin_id;
            $activity['activity_type'] = 'success';
            $activity['activity_name'] = $data['permission_name'] . ' Has Created For Role ID -' . $data['fk_role_id'];
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
    }

    public function delete_permission($role_id, $permission_name)
    {
        $permission_status = $this->check_permission('delete_permission');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $permission_model = new PermissionModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');
        $permission_delete = $permission_model->where('fk_role_id', $role_id)->where('permission_name', $permission_name)->delete();

        if ($permission_delete) :
            /* Activity Insert Start */
            $activity = array();
            $activity['fk_admin_id'] = $admin_id;
            $activity['activity_type'] = 'warning';
            $activity['activity_name'] = $permission_name . ' Has Deleted For Role ID -' . $role_id;
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
    }

    /* 006. Maintenance */

    public function maintenance()
    {
        $permission_status = $this->check_permission('view_maintenance');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Maintenance';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/maintenance', $data);
        return view('dashboard/master', $data);
    }

    /* 007. Admins */

    public function admins()
    {
        $permission_status = $this->check_permission('view_admin');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Admin';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/admins', $data);
        return view('dashboard/master', $data);
    }

    public function admin_datatable()
    {
        $permission_status = $this->check_permission('add_admin');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $admin_model = new AdminModel();
        $admins = $admin_model->find();

        $data = [];
        foreach ($admins as $r) {
            $data[] = array(
                $r['admin_id'],
                $r['first_name'],
                $r['last_name'],
                $r['user_name'],
                $r['admin_email'],
                $r['admin_mobile'],
                $r['admin_address']
            );
        }
        $result = array(
            "recordsTotal" => $admin_model->countAll(),
            "recordsFiltered" => $admin_model->countAll(),
            "data" => $data
        );
        echo json_encode($result);
        exit();
    }

    public function add_admin()
    {
        $permission_status = $this->check_permission('add_admin');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Add Admin';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/add_admin', $data);
        return view('dashboard/master', $data);
    }

    public function save_admin()
    {
        $permission_status = $this->check_permission('add_admin');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $admin_model = new AdminModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        $data = array();
        $data['first_name'] = $this->request->getPost('first_name');
        $data['last_name'] = $this->request->getPost('last_name');
        $data['admin_mobile'] = $this->request->getPost('admin_mobile');
        $data['admin_email'] = $this->request->getPost('admin_email');
        $data['user_name'] = $this->request->getPost('user_name');
        $data['admin_password'] = $this->request->getPost('admin_password');

        if ($this->request->getFile('image')) :
            $img = $this->request->getFile('image');
            $img->move(WRITEPATH . '../public/uploads/profile_image/');
            $data['admin_image'] = $img->getName();
        endif;

        $data['admin_sex'] = $this->request->getPost('sex');
        $data['admin_address'] = $this->request->getPost('admin_address');
        $data['admin_status'] = $this->request->getPost('status');
        $data['create_time'] = current_time();
        $data['create_date'] = current_date();
        $data['created_by'] = $admin_id;

        try {
            $admin_model->insert($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }

        $fk_admin_id = $admin_model->getInsertID();

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'success';
        $activity['activity_name'] = 'Admin Created - ' . $fk_admin_id;
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

        echo "<div class='alert alert-primary'>Admin Saved</div>";
        exit();
    }

    /* 008. Settings */

    public function settings()
    {
        $permission_status = $this->check_permission('view_setting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;
        $data = array();
        $data['title'] = 'Settings';
        $data['settings'] = $this->data['settings'];
        $data['user_name'] = $this->session->get('user_name');
        $data['admin_image'] = $this->session->get('admin_image');
        $data['permissions'] = $this->session->get('permissions');
        $data['all_notifications'] = $this->session->get('notifications');
        $data['unseen_notifications'] = $this->session->get('total_notifications');
        $data['home'] = view('dashboard/settings', $data);
        return view('dashboard/master', $data);
    }

    public function save_settings()
    {
        $permission_status = $this->check_permission('edit_setting');
        if ($permission_status) :
            return redirect()->to('/dashboard')->with('error', $permission_status);
        endif;

        $configuration_model = new ConfigModel();
        $activity_model = new ActivityModel();
        $admin_id = $this->session->get('admin_id');

        foreach ($_POST as $key => $value) {
            try {
                $configuration_model
                    ->where('config_name', $key)
                    ->set('config_setting', $value)
                    ->update();
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        /* Activity Insert Start */

        $activity = array();
        $activity['fk_admin_id'] = $admin_id;
        $activity['activity_type'] = 'warning';
        $activity['activity_name'] = 'Settings Changed';
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
