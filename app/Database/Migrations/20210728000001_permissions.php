<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Permissions extends Migration {

    public function up() {
        $this->forge->addField([
            'permission_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'fk_role_id' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
            ],
            'permission_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ]
        ]);
        $this->forge->addKey('permission_id', true);
        $this->forge->createTable('permissions');
    }

    public function down() {
        $this->forge->dropTable('permissions');
    }
}