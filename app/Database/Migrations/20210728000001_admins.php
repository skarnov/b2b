<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admins extends Migration {

    public function up() {
        $this->forge->addField([
            'admin_id' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'admin_sex' => [
                'type' => 'ENUM',
                'constraint' => ['male', 'female'],
                'null' => true,
            ],
            'admin_email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'unique' => true,
            ],
            'admin_password' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true,
            ],
            'admin_image' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'admin_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'admin_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'admin_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
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
        $this->forge->addKey('admin_id', true);
        $this->forge->createTable('admins');
    }

    public function down() {
        $this->forge->dropTable('admins');
    }
}