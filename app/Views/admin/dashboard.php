<?= $this->include('partials/header', ['title' => 'Dashboard Admin - SIGAP']) ?>

<div class="mb-6">
    <p class="font-mono text-xs uppercase tracking-widest text-ink/40 mb-1">Panel Admin</p>
    <h1 class="text-2xl font-bold">Dashboard</h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <p class="text-sm text-closed mb-4"><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <p class="text-sm text-open mb-4"><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-surface border border-line border-t-4 border-t-open rounded-md p-5">
        <p class="font-mono text-xs uppercase tracking-widest text-ink/40 mb-2">Open</p>
        <p class="text-3xl font-bold text-open"><?= $summary['open'] ?></p>
    </div>
    <div class="bg-surface border border-line border-t-4 border-t-progress rounded-md p-5">
        <p class="font-mono text-xs uppercase tracking-widest text-ink/40 mb-2">In Progress</p>
        <p class="text-3xl font-bold text-progress"><?= $summary['in_progress'] ?></p>
    </div>
    <div class="bg-surface border border-line border-t-4 border-t-closed rounded-md p-5">
        <p class="font-mono text-xs uppercase tracking-widest text-ink/40 mb-2">Closed</p>
        <p class="text-3xl font-bold text-closed"><?= $summary['closed'] ?></p>
    </div>
</div>

<div class="bg-surface border border-line rounded-md overflow-hidden">
    <table class="w-full text-sm text-left">
        <thead class="bg-canvas border-b border-line">
            <tr class="font-mono text-xs uppercase tracking-wide text-ink/50">
                <th class="px-4 py-3 font-medium">No</th>
                <th class="px-4 py-3 font-medium">Judul</th>
                <th class="px-4 py-3 font-medium">Kategori</th>
                <th class="px-4 py-3 font-medium">Status</th>
                <th class="px-4 py-3 font-medium">Dibuat</th>
                <th class="px-4 py-3 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-line">
            <?php $no = 1; ?>
            <?php foreach ($tickets as $t): ?>
                <?php
                    $statusClass = [
                        'open'        => 'bg-open-soft text-open',
                        'in_progress' => 'bg-progress-soft text-progress',
                        'closed'      => 'bg-closed-soft text-closed',
                    ][$t['status']];
                ?>
                <tr class="hover:bg-canvas/60 transition">
                    <td class="px-4 py-3 text-ink/50"><?= $no++ ?></td>
                    <td class="px-4 py-3 font-medium"><?= esc($t['judul']) ?></td>
                    <td class="px-4 py-3 text-ink/70"><?= esc($t['kategori']) ?></td>
                    <td class="px-4 py-3">
                        <span class="font-mono text-xs px-2 py-1 rounded-sm <?= $statusClass ?>">
                            [ <?= strtoupper(esc($t['status'])) ?> ]
                        </span>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-ink/50"><?= esc($t['created_at']) ?></td>
                    <td class="px-4 py-3">
                        <a href="/admin/tickets/<?= $t['id'] ?>" class="text-primary hover:underline font-medium">Detail</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->include('partials/footer') ?>