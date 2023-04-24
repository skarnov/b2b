<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleRelation extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'role_relation_id' => [
                'type' => 'INT',
                'constraint' => 4,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'fk_admin_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'fk_role_id' => [
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('role_relation_id', true);
        $this->forge->createTable('role_relation');
    }

    public function down()
    {
        $this->forge->dropTable('role_relation');
    }
}
