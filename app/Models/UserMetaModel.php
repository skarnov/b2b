<?php

namespace App\Models;

use CodeIgniter\Model;

class UserMetaModel extends Model {

    protected $table = 'usermeta';
    protected $primaryKey = 'usermeta_id';
    protected $allowedFields = ['fk_user_id', 'meta_key', 'meta_value'];

}