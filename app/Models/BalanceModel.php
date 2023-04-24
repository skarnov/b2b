<?php

namespace App\Models;

use CodeIgniter\Model;

class BalanceModel extends Model {

    protected $table = 'balances';
    protected $primaryKey = 'balance_id';
    protected $allowedFields = ['fk_user_id', 'balance_amount', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}