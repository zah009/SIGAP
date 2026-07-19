<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
    'user_id', 'kategori', 'judul', 'deskripsi',
    'status', 'lampiran', 'created_at', 'updated_at',
    'sla_hours', 'sla_deadline', 'sla_notified',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'kategori'  => 'required|in_list[hardware,software,jaringan,akun]',
        'judul'     => 'required|min_length[5]|max_length[150]',
        'deskripsi' => 'required|min_length[10]',
        'status'    => 'permit_empty|in_list[open,in_progress,closed]',
    ];

    protected $validationMessages = [
        'judul' => [
            'min_length' => 'Judul terlalu pendek, jelaskan sedikit lebih detail.',
        ],
    ];
}