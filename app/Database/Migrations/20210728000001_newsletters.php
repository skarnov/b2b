<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Newsletters extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'newsletter_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'newsletter_email' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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
        $this->forge->addKey('newsletter_id', true);
        $this->forge->createTable('newsletters');
    }

    public function down()
    {
        $this->forge->dropTable('newsletters');
    }
}