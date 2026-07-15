<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;

class Dashboard extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    public function index()
    {
        $tickets = $this->ticketModel->orderBy('created_at', 'DESC')->findAll();

        $summary = [
            'open'        => $this->ticketModel->where('status', 'open')->countAllResults(),
            'in_progress' => $this->ticketModel->where('status', 'in_progress')->countAllResults(),
            'closed'      => $this->ticketModel->where('status', 'closed')->countAllResults(),
        ];

        return view('admin/dashboard', ['tickets' => $tickets, 'summary' => $summary]);
    }
}