<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model {

    protected $table = 'sales';
    protected $primaryKey = 'sale_id';
    protected $allowedFields = ['table_name', 'fk_reference_id', 'fk_user_id', 'fk_partner_id', 'invoice_id', 'sale_description', 'due_date', 'net_price', 'discount_amount', 'grand_total', 'buying_price', 'sale_due', 'sale_status', 'sale_note', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}