<?php

namespace App\Models;

use CodeIgniter\Model;

class HostingModel extends Model
{
    protected $table = 'hostings';
    protected $primaryKey = 'hosting_id';
    protected $allowedFields = ['fk_user_id', 'fk_partner_id', 'fk_package_id', 'hosting_space', 'primary_domain', 'hosting_email', 'hosting_mobile', 'renew_for', 'renew_date', 'expiry_date', 'cpanel_url', 'cpanel_username', 'cpanel_password', 'email_url', 'email_username', 'email_password', 'hosting_note', 'hosting_status', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];
}
