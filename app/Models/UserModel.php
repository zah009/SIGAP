<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = ['username', 'password_hash', 'role', 'nama_lengkap', 'created_at'];

    protected $useTimestamps = false; 

    protected $validationRules = [
        'username'      => 'required|min_length[4]|max_length[50]|is_unique[users.username,id,{id}]',
        'nama_lengkap'  => 'required|max_length[100]',
        'role'          => 'required|in_list[user,admin]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah dipakai, pilih yang lain.',
        ],
    ];
}