<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ticketModel = new TicketModel();
        $userId = session()->get('user_id');

        $summary = [
            'open'        => $ticketModel->where('user_id', $userId)->where('status', 'open')->countAllResults(),
            'in_progress' => $ticketModel->where('user_id', $userId)->where('status', 'in_progress')->countAllResults(),
            'closed'      => $ticketModel->where('user_id', $userId)->where('status', 'closed')->countAllResults(),
        ];

        $recentTickets = $ticketModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->find();

        return view('dashboard', [
            'summary'       => $summary,
            'recentTickets' => $recentTickets,
        ]);
    }
}