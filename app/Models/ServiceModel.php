<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model {

    protected $table = 'services';
    protected $primaryKey = 'service_id';
    protected $allowedFields = ['fk_user_id', 'service_name', 'service_url', 'service_username', 'service_password', 'service_note', 'expiry_date', 'service_status', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}