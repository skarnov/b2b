<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notifications extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'notification_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'notification_title' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'notification_link' => [
                'type' => 'TEXT',
            ],
            'notification' => [
                'type' => 'TEXT',
            ],
            'view_status' => [
                'type' => 'ENUM',
                'constraint' => ['seen', 'unseen'],
                'default' => 'unseen',
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

        ]);
        $this->forge->addKey('notification_id', true);
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
