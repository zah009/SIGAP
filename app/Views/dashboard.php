<?= $this->include('partials/header', ['title' => 'Dashboard - SIGAP']) ?>

<h1 class="text-2xl font-bold mb-1">Halo, <?= esc(session()->get('username')) ?></h1>
<p class="text-gray-500 mb-6">Role: <?= esc(session()->get('role')) ?></p>

<h3 class="font-semibold mb-2">Ringkasan Laporan Saya</h3>
<p class="mb-4">
    Open: <?= $summary['open'] ?> |
    In Progress: <?= $summary['in_progress'] ?> |
    Closed: <?= $summary['closed'] ?>
</p>

<?php if (session()->getFlashdata('success')): ?>
    <p class="text-green-600"><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>

<?= $this->include('partials/footer') ?>