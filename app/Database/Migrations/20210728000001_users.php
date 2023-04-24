<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'facebook_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'google_id' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
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
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'unique' => true,
            ],
            'user_sex' => [
                'type' => 'ENUM',
                'constraint' => ['male', 'female'],
                'null' => true,
            ],
            'user_password' => [
                'type' => 'VARCHAR',
                'constraint' => '256',
                'null' => true,
            ],
            'user_image' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'user_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'user_address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'archive'],
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
        $this->forge->addKey('user_id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
