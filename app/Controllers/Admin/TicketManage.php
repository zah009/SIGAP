<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TicketModel;
use App\Models\TicketLogModel;
use App\Models\UserModel;

class TicketManage extends BaseController
{
    protected $ticketModel;
    protected $logModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->logModel    = new TicketLogModel();
    }

    public function show($id)
    {
        $ticket = $this->ticketModel
            ->select('tickets.*, users.username, users.nama_lengkap, users.email as reporter_email')
            ->join('users', 'users.id = tickets.user_id')
            ->where('tickets.id', $id)
            ->first();

        if (!$ticket) {
            return redirect()->to('/admin/dashboard')->with('error', 'Tiket tidak ditemukan.');
        }

        $logs = $this->logModel->where('ticket_id', $id)->orderBy('created_at', 'ASC')->findAll();

        return view('admin/ticket_detail', ['ticket' => $ticket, 'logs' => $logs]);
    }

    public function updateStatus($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->to('/admin/dashboard')->with('error', 'Tiket tidak ditemukan.');
        }

        $status  = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        if (!in_array($status, ['open', 'in_progress', 'closed'])) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        if (empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan wajib diisi setiap update status.');
        }

        $this->ticketModel->update($id, ['status' => $status]);

        $this->logModel->insert([
            'ticket_id' => $id,
            'admin_id'  => session()->get('user_id'),
            'catatan'   => $catatan,
        ]);

        $this->notifyUser($ticket, $status, $catatan);

        session()->setFlashdata('success', 'Status tiket berhasil diupdate.');
        return redirect()->to('/admin/tickets/' . $id);
    }

    private function notifyUser($ticket, $status, $catatan)
    {
        $userModel = new UserModel();
        $user = $userModel->find($ticket['user_id']);

        if (empty($user['email'])) {
            log_message('info', 'Email tidak dikirim: user tidak punya alamat email.');
            return;
        }

        $email = \Config\Services::email();
        $email->setTo($user['email']);
        $email->setSubject('Update Tiket: ' . $ticket['judul']);
        $email->setMessage(
            "Halo {$user['nama_lengkap']},\n\n" .
            "Status laporan Anda \"{$ticket['judul']}\" telah diperbarui menjadi: {$status}.\n\n" .
            "Catatan dari tim IT:\n{$catatan}\n\n" .
            "— SIGAP"
        );

        try {
            $email->send();
        } catch (\Exception $e) {
            log_message('error', 'Gagal kirim email: ' . $e->getMessage());
        }
    }
}