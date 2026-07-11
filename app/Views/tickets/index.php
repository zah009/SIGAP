<?= $this->include('partials/header', ['title' => 'Riwayat Laporan - SIGAP']) ?>

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold">Riwayat Laporan Saya</h1>
    <a href="/tickets/create" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-md transition">
        + Buat Laporan Baru
    </a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <p class="text-green-600 text-sm mb-4"><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>

<?php if (empty($tickets)): ?>
    <p class="text-gray-500">Belum ada laporan.</p>
<?php else: ?>
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php foreach ($tickets as $t): ?>
                    <tr>
                        <td class="px-4 py-3"><?= esc($t['judul']) ?></td>
                        <td class="px-4 py-3"><?= esc($t['kategori']) ?></td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                <?= $t['status'] === 'open' ? 'bg-yellow-100 text-yellow-700' : '' ?>
                                <?= $t['status'] === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' ?>
                                <?= $t['status'] === 'closed' ? 'bg-green-100 text-green-700' : '' ?>">
                                <?= esc($t['status']) ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500"><?= esc($t['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <?= $pager->links() ?>
    </div>
<?php endif; ?>

<?= $this->include('partials/footer') ?>