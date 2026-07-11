<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Ticket extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    private function blockAdmin()
    {
        if (session()->get('role') === 'admin') {
            return redirect()->to('/admin/dashboard')
                ->with('error', 'Admin tidak membuat laporan, khusus kelola tiket pengguna.');
        }
        return null;
    }

    public function create()
{
    

    if ($block = $this->blockAdmin()) return $block;
    return view('tickets/create');
}

    public function store()
    {
        if ($block = $this->blockAdmin()) return $block;

        $rules = [
            'kategori'  => 'required|in_list[hardware,software,jaringan,akun]',
            'judul'     => 'required|min_length[5]|max_length[150]',
            'deskripsi' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/tickets/create')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->ticketModel->insert([
            'user_id'   => session()->get('user_id'),
            'kategori'  => $this->request->getPost('kategori'),
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status'    => 'open',
        ]);

        session()->setFlashdata('success', 'Tiket berhasil dibuat.');
        return redirect()->to('/dashboard');
    }

    public function myTickets()
    {
        if ($block = $this->blockAdmin()) return $block;

        $tickets = $this->ticketModel
            ->where('user_id', session()->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('tickets/index', [
            'tickets' => $tickets,
            'pager'   => $this->ticketModel->pager,
        ]);
    }
}