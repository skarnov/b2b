<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Incomes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'income_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'fk_transaction_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'income_description' => [
                'type' => 'TEXT',
            ],
            'income_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'default' => 0.00,
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
        $this->forge->addKey('income_id', true);
        $this->forge->createTable('incomes');
    }

    public function down()
    {
        $this->forge->dropTable('incomes');
    }
}