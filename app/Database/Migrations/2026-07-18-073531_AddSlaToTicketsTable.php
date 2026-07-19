<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlaToTicketsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tickets', [
            'sla_hours' => [
                'type' => 'INT',
                'null' => true,
                'after' => 'lampiran',
            ],
            'sla_deadline' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'sla_hours',
            ],
            'sla_notified' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'sla_deadline',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tickets', ['sla_hours', 'sla_deadline', 'sla_notified']);
    }
}