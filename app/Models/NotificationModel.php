<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model {

    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    protected $allowedFields = ['notification_title', 'notification_link', 'notification', 'view_status', 'create_time', 'create_date', 'created_by'];

}