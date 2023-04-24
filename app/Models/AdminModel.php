<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model {

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    protected $allowedFields = ['first_name', 'last_name', 'user_name', 'admin_sex', 'admin_email', 'admin_password', 'admin_image', 'admin_mobile', 'admin_address', 'admin_status ', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}