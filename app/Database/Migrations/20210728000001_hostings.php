<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Hostings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'hosting_id' => [
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
            'fk_package_id' => [
                'type' => 'INT',
                'constraint' => 3,
                'null' => true,
            ],
            'hosting_space' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'primary_domain' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],
            'hosting_email' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'hosting_mobile' => [
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
            'cpanel_url' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'cpanel_username' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'cpanel_password' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'email_url' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email_username' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'email_password' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'hosting_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'hosting_status' => [
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
        $this->forge->addKey('hosting_id', true);
        $this->forge->createTable('hostings');
    }

    public function down()
    {
        $this->forge->dropTable('hostings');
    }
}
