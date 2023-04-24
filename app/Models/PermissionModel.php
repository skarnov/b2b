<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model {

    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';
    protected $allowedFields = ['fk_role_id', 'permission_name'];

}