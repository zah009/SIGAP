<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTicketsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'kategori' => [
                'type'       => 'ENUM',
                'constraint' => ['hardware', 'software', 'jaringan', 'akun'],
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['open', 'in_progress', 'closed'],
                'default'    => 'open',
            ],
            'lampiran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tickets');
    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}