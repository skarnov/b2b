<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configurations extends Migration {

    public function up() {
        $this->forge->addField([
            'config_id' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'config_name' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
            ],
            'config_setting' => [
                'type' => 'TEXT',
            ]
        ]);
        $this->forge->addKey('config_id', true);
        $this->forge->createTable('configurations');
    }

    public function down() {
        $this->forge->dropTable('configurations');
    }
}