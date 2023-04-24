<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HostingPackages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'package_id' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'package_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'website_host' => [
                'type' => 'TINYINT',
                'constraint' => '2',
            ],
            'database_host' => [
                'type' => 'TINYINT',
                'constraint' => '2',
            ],
            'package_storage' => [
                'type' => 'TINYINT',
                'constraint' => '2',
            ],
            'ftp_account' => [
                'type' => 'TINYINT',
                'constraint' => '2',
            ],
            'email_account' => [
                'type' => 'TINYINT',
                'constraint' => '2',
            ],
            'package_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive']
            ],
            'create_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'create_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
                'null' => true,
            ],
            'modify_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'modify_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'modified_by' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('package_id', true);
        $this->forge->createTable('hosting_packages');
    }

    public function down()
    {
        $this->forge->dropTable('hosting_packages');
    }
}
