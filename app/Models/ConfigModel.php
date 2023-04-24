<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model {

    protected $table = 'configurations';
    protected $primaryKey = 'config_id';
    protected $allowedFields = ['config_name', 'config_setting'];

}