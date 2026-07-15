<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'      => 'testadmin',
            'email'         => 'saidhamzah12@gmail.com',
            'password_hash' => password_hash('test123', PASSWORD_DEFAULT),
            'role'          => 'admin',
            'nama_lengkap'  => 'Test Admin',
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $existing = $this->db->table('users')->where('username', $data['username'])->get()->getRow();

        if ($existing) {
            $this->db->table('users')
                ->where('username', $data['username'])
                ->update($data);
        } else {
            $this->db->table('users')->insert($data);
        }
    }
}