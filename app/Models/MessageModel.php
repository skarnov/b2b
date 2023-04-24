<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'message_id';
    protected $allowedFields = ['name', 'email', 'message', 'create_time', 'create_date'];
}