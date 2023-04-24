<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model {

    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';
    protected $allowedFields = ['fk_ticket_id', 'fk_user_id', 'fk_admin_id', 'service_name', 'ticket_content', 'ticket_status', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}