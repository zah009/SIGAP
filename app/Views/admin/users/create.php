<?= $this->include('partials/header', ['title' => 'Tambah User - SIGAP']) ?>

<a href="/admin/users" class="text-sm text-blue-600 hover:underline">← Kembali</a>

<h1 class="text-2xl font-bold mb-6 mt-4">Tambah User Baru</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <ul class="bg-red-50 text-red-700 text-sm rounded-md px-4 py-3 mb-4 list-disc list-inside">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/admin/users/store" method="post" class="bg-white p-6 rounded-lg shadow-sm max-w-lg">
    <?= csrf_field() ?>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="<?= esc(old('nama_lengkap')) ?>"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Username</label>
        <input type="text" name="username" value="<?= esc(old('username')) ?>"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="<?= esc(old('email')) ?>"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
        <input type="password" name="password_confirm"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-md transition">
        Buat User
    </button>
</form>

<?= $this->include('partials/footer') ?>