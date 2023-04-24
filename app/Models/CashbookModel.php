<?php

namespace App\Models;

use CodeIgniter\Model;

class CashbookModel extends Model {

    protected $table = 'cashbook';
    protected $primaryKey = 'cashbook_id';
    protected $allowedFields = ['table_name', 'fk_reference_id', 'cashbook_description', 'in_amount', 'out_amount', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}