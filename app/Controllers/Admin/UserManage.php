<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManage extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel
            ->where('role', 'user')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('admin/users/index', ['users' => $users]);
    }

    public function create()
    {
        return view('admin/users/create');
    }

    public function store()
    {
        $rules = [
            'username'          => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'             => 'required|valid_email|is_unique[users.email]',
            'nama_lengkap'      => 'required|min_length[3]|max_length[100]',
            'password'          => 'required|min_length[8]',
            'password_confirm'  => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/admin/users/create')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $inserted = $this->userModel->insert([
            'username'      => $this->request->getPost('username'),
            'email'         => trim($this->request->getPost('email')),
            'nama_lengkap'  => $this->request->getPost('nama_lengkap'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'          => 'user',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);

        if (!$inserted) {
            $modelErrors = $this->userModel->errors();

            return redirect()->to('/admin/users/create')
                ->withInput()
                ->with('errors', $modelErrors ?: ['Gagal menyimpan user, coba lagi.']);
        }

        session()->setFlashdata('success', 'User baru berhasil dibuat.');
        return redirect()->to('/admin/users');
    }
}