<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Domains extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'domain_id' => [
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'fk_user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'fk_partner_id' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'domain_name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'domain_email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'domain_mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'renew_for' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => '1 Year',
            ],
            'renew_date' => [
                'type' => 'DATE',
            ],
            'expiry_date' => [
                'type' => 'DATE',
            ],
            'panel_url' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'panel_username' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'panel_password' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'domain_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'domain_status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'deleted']
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
        $this->forge->addKey('domain_id', true);
        $this->forge->createTable('domains');
    }

    public function down()
    {
        $this->forge->dropTable('domains');
    }
}