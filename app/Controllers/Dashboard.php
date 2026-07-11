<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();

        $summary = [
            'open'        => $ticketModel->where('user_id', session()->get('user_id'))->where('status', 'open')->countAllResults(),
            'in_progress' => $ticketModel->where('user_id', session()->get('user_id'))->where('status', 'in_progress')->countAllResults(),
            'closed'      => $ticketModel->where('user_id', session()->get('user_id'))->where('status', 'closed')->countAllResults(),
        ];

        return view('dashboard', ['summary' => $summary]);
    }
}