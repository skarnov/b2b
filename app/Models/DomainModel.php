<?php

namespace App\Models;

use CodeIgniter\Model;

class DomainModel extends Model
{
    protected $table = 'domains';
    protected $primaryKey = 'domain_id';
    protected $allowedFields = ['fk_user_id', 'fk_partner_id', 'domain_name', 'domain_email', 'domain_mobile', 'renew_for', 'renew_date', 'expiry_date', 'panel_url', 'panel_username', 'panel_password', 'domain_note', 'domain_status', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];
}
