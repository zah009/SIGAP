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

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}