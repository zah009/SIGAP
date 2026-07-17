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

    if ($this->request->getGet('error') === 'filesize') {
        session()->setFlashdata('errors', ['Ukuran file yang diupload terlalu besar. Maksimal 2MB.']);
    }

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

    $lampiranName = null;
    $file = $this->request->getFile('lampiran');

    // Ada file yang dicoba diupload (bukan field kosong)
    if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {

        // File ditolak di level PHP (misal melebihi upload_max_filesize/post_max_size)
        // sebelum sempat dicek getSize() di bawah — sebelumnya kasus ini diam-diam
        // membuat tiket tanpa lampiran tanpa memberi tahu user.
        if (!$file->isValid()) {
            return redirect()->to('/tickets/create')
                ->withInput()
                ->with('errors', ['Ukuran file yang diupload terlalu besar. Maksimal 2MB.']);
        }

        if ($file->hasMoved()) {
            return redirect()->to('/tickets/create')
                ->withInput()
                ->with('errors', ['Terjadi kesalahan saat memproses lampiran. Silakan coba lagi.']);
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];
        $realMime = $file->getMimeType();

        if (!in_array($realMime, $allowedMimes, true)) {
            return redirect()->to('/tickets/create')
                ->withInput()
                ->with('errors', ['Format lampiran tidak diizinkan. Hanya JPG, PNG, atau PDF yang boleh diupload.']);
        }

        if ($file->getSize() > 2048 * 1024) {
            return redirect()->to('/tickets/create')
                ->withInput()
                ->with('errors', ['Ukuran lampiran maksimal 2MB.']);
        }

        $lampiranName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/tickets', $lampiranName);
    }

    $this->ticketModel->insert([
        'user_id'   => session()->get('user_id'),
        'kategori'  => $this->request->getPost('kategori'),
        'judul'     => $this->request->getPost('judul'),
        'deskripsi' => $this->request->getPost('deskripsi'),
        'status'    => 'open',
        'lampiran'  => $lampiranName,
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