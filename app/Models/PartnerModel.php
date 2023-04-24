<?php

namespace App\Models;

use CodeIgniter\Model;

class PartnerModel extends Model {

    protected $table = 'partners';
    protected $primaryKey = 'partner_id';
    protected $allowedFields = ['partner_name', 'total_investment', 'remaining_investment', 'total_profit', 'partner_status', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}