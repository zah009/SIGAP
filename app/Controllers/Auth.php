<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function showLogin()
    {
        return view('auth/login');
    }

   public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if (empty($username) || empty($password)) {
            session()->setFlashdata('error', 'Username dan password wajib diisi.');
            return redirect()->to('/login');
        }

        $ip = $this->request->getIPAddress();
        $throttler = \Config\Services::throttler();

        // Lapis 1: batasi total percobaan login dari 1 IP (cegah mass scanning banyak akun)
        if ($throttler->check('login_ip_' . md5($ip), 20, MINUTE) === false) {
            session()->setFlashdata('error', 'Terlalu banyak percobaan login. Coba lagi dalam beberapa menit.');
            return redirect()->to('/login');
        }

        // Lapis 2: batasi percobaan ke satu akun spesifik (cegah brute-force ke 1 username)
        $throttleKey = 'login_user_' . md5($ip . ':' . strtolower($username));
        if ($throttler->check($throttleKey, 2, MINUTE) === false) {
            session()->setFlashdata('error', 'Terlalu banyak percobaan login untuk akun ini. Coba lagi dalam beberapa menit.');
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            session()->setFlashdata('error', 'Username atau password salah.');
            return redirect()->to('/login');
        }

        session()->set([
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'role'       => $user['role'],
            'logged_in'  => true,
        ]);

        if ($user['role'] === 'admin') {
            return redirect()->to('/admin/dashboard');
        }

        return redirect()->to('/dashboard');
    }

    public function forgotPasswordForm()
{
    return view('auth/forgot_password');
}

public function sendResetLink()
{
    $email = $this->request->getPost('email');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        session()->setFlashdata('error', 'Masukkan alamat email yang valid.');
        return redirect()->to('/forgot-password');
    }

    $userModel = new UserModel();
    $user = $userModel->where('email', $email)->first();

    // Pesan ini SENGAJA sama baik email ditemukan atau tidak — mencegah user enumeration
    session()->setFlashdata('success', 'Jika email terdaftar di sistem, tautan reset password telah dikirim.');

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $hashedToken = hash('sha256', $token);
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $userModel->update($user['id'], [
            'reset_token'         => $hashedToken,
            'reset_token_expires' => $expires,
        ]);

        $resetLink = base_url('reset-password/' . $token);

        $mail = \Config\Services::email();
        $mail->setTo($user['email']);
        $mail->setSubject('Reset Password - SIGAP');
        $mail->setMessage(
            "Halo {$user['nama_lengkap']},\n\n" .
            "Kami menerima permintaan reset password untuk akun Anda.\n" .
            "Klik tautan berikut untuk membuat password baru (berlaku 1 jam):\n\n" .
            "{$resetLink}\n\n" .
            "Jika Anda tidak meminta ini, abaikan email ini.\n\n" .
            "— SIGAP"
        );

        try {
            $mail->send();
        } catch (\Exception $e) {
            log_message('error', 'Gagal kirim email reset password: ' . $e->getMessage());
        }
    }

    return redirect()->to('/forgot-password');
}

public function resetPasswordForm($token)
{
    $hashedToken = hash('sha256', $token);
    $userModel = new UserModel();
    $user = $userModel->where('reset_token', $hashedToken)
                       ->where('reset_token_expires >=', date('Y-m-d H:i:s'))
                       ->first();

    if (!$user) {
        session()->setFlashdata('error', 'Tautan reset password tidak valid atau sudah kedaluwarsa.');
        return redirect()->to('/forgot-password');
    }

    return view('auth/reset_password', ['token' => $token]);
}

    public function updatePassword()
    {
        $token           = $this->request->getPost('token');
        $password        = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        $hashedToken = hash('sha256', $token);
        $userModel = new UserModel();
        $user = $userModel->where('reset_token', $hashedToken)
                        ->where('reset_token_expires >=', date('Y-m-d H:i:s'))
                        ->first();

        if (!$user) {
            session()->setFlashdata('error', 'Tautan reset password tidak valid atau sudah kedaluwarsa.');
            return redirect()->to('/forgot-password');
        }

        if (strlen($password) < 8) {
            session()->setFlashdata('error', 'Password minimal 8 karakter.');
            return redirect()->to('/reset-password/' . $token);
        }

        if ($password !== $passwordConfirm) {
            session()->setFlashdata('error', 'Konfirmasi password tidak cocok.');
            return redirect()->to('/reset-password/' . $token);
        }

        $userModel->update($user['id'], [
            'password_hash'       => password_hash($password, PASSWORD_DEFAULT),
            'reset_token'         => null,
            'reset_token_expires' => null,
        ]);

        session()->setFlashdata('success', 'Password berhasil diubah, silakan login dengan password baru.');
        return redirect()->to('/login');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

}