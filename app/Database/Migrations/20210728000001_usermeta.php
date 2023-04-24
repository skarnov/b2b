<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usermeta extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'usermeta_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'fk_user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],
            'meta_key' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'meta_value' => [
                'type' => 'TEXT',
            ]
        ]);
        $this->forge->addKey('usermeta_id', true);
        $this->forge->createTable('usermeta');
    }

    public function down()
    {
        $this->forge->dropTable('usermeta');
    }
}
