<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\UserModel;

class UserModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $namespace = null; // null = jalankan migration dari SEMUA namespace, termasuk App

    public function testUsernameWajibDiisi()
    {
        $model = new UserModel();
        $result = $model->insert([
            'username'     => '',
            'password_hash' => password_hash('test123', PASSWORD_DEFAULT),
            'role'         => 'user',
            'nama_lengkap' => 'Test User',
        ]);

        $this->assertFalse($result);
    }

    public function testEmailHarusFormatValid()
    {
        $model = new UserModel();
        $model->insert([
            'username'     => 'testuser99',
            'email'        => 'bukan-email-valid',
            'password_hash' => password_hash('test123', PASSWORD_DEFAULT),
            'role'         => 'user',
            'nama_lengkap' => 'Test User',
        ]);

        $this->assertArrayHasKey('email', $model->errors());
    }
}