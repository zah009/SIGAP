<?= $this->include('partials/header', ['title' => 'Kelola User - SIGAP']) ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Kelola User</h1>
    <a href="/admin/users/create" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md transition">
        + Tambah User
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <p class="text-green-600 text-sm mb-4"><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>

<?php if (empty($users)): ?>
    <p class="text-gray-500">Belum ada user.</p>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Nama Lengkap</th>
                    <th class="px-4 py-3">Username</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="px-4 py-3"><?= esc($u['nama_lengkap']) ?></td>
                        <td class="px-4 py-3"><?= esc($u['username']) ?></td>
                        <td class="px-4 py-3"><?= esc($u['email']) ?></td>
                        <td class="px-4 py-3 text-gray-500"><?= esc($u['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?= $this->include('partials/footer') ?>