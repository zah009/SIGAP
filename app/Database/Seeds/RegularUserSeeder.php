<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegularUserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'      => 'user1',
            'email'         => 'musicprojeck910@gmail.com',
            'password_hash' => password_hash('user123', PASSWORD_DEFAULT),
            'role'          => 'user',
            'nama_lengkap'  => 'User Divisi Keuangan',
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }
}