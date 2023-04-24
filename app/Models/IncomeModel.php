<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomeModel extends Model {

    protected $table = 'incomes';
    protected $primaryKey = 'income_id';
    protected $allowedFields = ['fk_transaction_id', 'income_description', 'income_amount', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}