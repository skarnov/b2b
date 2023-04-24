<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Activities extends Migration {

    public function up() {
        $this->forge->addField([
            'activity_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'fk_admin_id' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
                'null' => true,
            ],
            'activity_type' => [
                'type' => 'ENUM',
                'constraint' => ['success', 'warning', 'error'],
            ],
            'activity_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => '45',
            ],
            'visitor_country' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'visitor_state' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'visitor_city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'visitor_address' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'create_time' => [
                'type' => 'TIME',
            ],
            'create_date' => [
                'type' => 'DATE',
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('activity_id', true);
        $this->forge->createTable('activities');
    }

    public function down() {
        $this->forge->dropTable('activities');
    }
}
