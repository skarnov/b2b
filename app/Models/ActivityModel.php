<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityModel extends Model {

    protected $table = 'activities';
    protected $primaryKey = 'activity_id';
    protected $allowedFields = ['fk_admin_id', 'activity_type', 'activity_name', 'ip_address', 'visitor_country', 'visitor_state', 'visitor_city', 'visitor_address', 'create_time', 'create_date', 'created_by'];

}