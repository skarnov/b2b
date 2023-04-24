<?php

namespace App\Models;

use CodeIgniter\Model;

class HostingPackageModel extends Model {

    protected $table = 'hosting_packages';
    protected $primaryKey = 'package_id';
    protected $allowedFields = ['package_name', 'package_price', 'website_host', 'database_host', 'package_storage', 'ftp_account', 'email_account', 'package_status', 'create_time', 'create_date', 'created_by', 'modify_time', 'modify_date', 'modified_by'];

}