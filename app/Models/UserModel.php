<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['first_name', 'last_name', 'user_name', 'user_sex', 'user_email', 'user_password', 'user_image', 'user_mobile', 'user_address', 'user_status ', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}