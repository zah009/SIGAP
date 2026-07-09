<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketLogModel extends Model
{
    protected $table            = 'ticket_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = ['ticket_id', 'admin_id', 'catatan', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; 

    protected $validationRules = [
        'catatan' => 'required|min_length[5]',
    ];
}