<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model {

    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    protected $allowedFields = ['transaction_date', 'transaction_type', 'fk_reference_id', 'transaction_amount', 'paid_amount', 'due_amount', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}