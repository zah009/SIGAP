<?= $this->include('partials/header', ['title' => 'Buat Laporan - SIGAP']) ?>

<h1 class="text-2xl font-bold mb-6">Buat Laporan Gangguan</h1>

<?php if (session()->getFlashdata('errors')): ?>
    <ul class="bg-red-50 text-red-700 text-sm rounded-md px-4 py-3 mb-4 list-disc list-inside">
        <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="/tickets/store" method="post" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm max-w-lg">
    <?= csrf_field() ?>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Kategori</label>
        <select name="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            <option value="hardware" <?= old('kategori') === 'hardware' ? 'selected' : '' ?>>Hardware</option>
            <option value="software" <?= old('kategori') === 'software' ? 'selected' : '' ?>>Software</option>
            <option value="jaringan" <?= old('kategori') === 'jaringan' ? 'selected' : '' ?>>Jaringan</option>
            <option value="akun" <?= old('kategori') === 'akun' ? 'selected' : '' ?>>Akun/Akses</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="judul" value="<?= esc(old('judul')) ?>"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="5"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?= esc(old('deskripsi')) ?></textarea>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium mb-1">Lampiran (opsional)</label>
        <input type="file" name="lampiran" accept=".jpg,.jpeg,.png,.pdf"
               class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
    </div>

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-md transition">
        Kirim Laporan
    </button>
</form>

<?= $this->include('partials/footer') ?>