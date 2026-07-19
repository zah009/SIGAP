<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\TicketModel;
use App\Models\UserModel;

class SlaCheck extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'sla:check';
    protected $description = 'Cek tiket yang melewati SLA dan kirim notifikasi email.';

    public function run(array $params)
    {
        $ticketModel = new TicketModel();
        $userModel   = new UserModel();

        $overdueTickets = $ticketModel
            ->where('status', 'in_progress')
            ->where('sla_deadline <', date('Y-m-d H:i:s'))
            ->where('sla_notified', 0)
            ->findAll();

        if (empty($overdueTickets)) {
            CLI::write('Tidak ada tiket yang melewati SLA.', 'green');
            return;
        }

        $admins      = $userModel->where('role', 'admin')->findAll();
        $adminEmails = array_column($admins, 'email');

        foreach ($overdueTickets as $ticket) {
            $owner = $userModel->find($ticket['user_id']);

            $recipients = $adminEmails;
            if ($owner && !empty($owner['email'])) {
                $recipients[] = $owner['email'];
            }
            $recipients = array_unique(array_filter($recipients));

            if (empty($recipients)) {
                CLI::write("Tiket #{$ticket['id']} lewat SLA tapi tidak ada email tujuan.", 'yellow');
                continue;
            }

            $mail = \Config\Services::email();
            $mail->setTo($recipients);
            $mail->setSubject("SLA Terlewati - Tiket #{$ticket['id']}: {$ticket['judul']}");
            $mail->setMessage(
                "Tiket berikut telah melewati batas waktu SLA:\n\n" .
                "ID Tiket   : {$ticket['id']}\n" .
                "Judul      : {$ticket['judul']}\n" .
                "Kategori   : {$ticket['kategori']}\n" .
                "Target SLA : {$ticket['sla_hours']} jam\n" .
                "Deadline   : {$ticket['sla_deadline']}\n\n" .
                "Mohon segera ditindaklanjuti.\n\n" .
                "— SIGAP"
            );

            try {
                $sent = $mail->send();
                if ($sent) {
                    $ticketModel->update($ticket['id'], ['sla_notified' => 1]);
                    CLI::write("Notifikasi terkirim untuk tiket #{$ticket['id']}.", 'green');
                } else {
                    CLI::write("Gagal kirim email tiket #{$ticket['id']}: " . $mail->printDebugger(['headers']), 'red');
                }
            } catch (\Exception $e) {
                log_message('error', 'Gagal kirim email SLA: ' . $e->getMessage());
                CLI::write("Error tiket #{$ticket['id']}: " . $e->getMessage(), 'red');
            }
        }
    }
}