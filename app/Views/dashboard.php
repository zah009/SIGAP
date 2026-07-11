<?= $this->include('partials/header', ['title' => 'Dashboard - SIGAP']) ?>

<div class="mb-6">
    <p class="font-mono text-xs uppercase tracking-widest text-ink/40 mb-1">Dashboard</p>
    <h1 class="text-2xl font-bold">Halo, <?= esc(session()->get('username')) ?></h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <p class="text-sm text-closed mb-4"><?= esc(session()->getFlashdata('success')) ?></p>
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

<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-ink/80">Laporan Terbaru</h2>
    <a href="/tickets/create" class="bg-primary hover:bg-primary-hover text-white text-sm font-medium px-4 py-2 rounded-md transition">
        + Buat Laporan
    </a>
</div>

<?php if (empty($recentTickets)): ?>
    <div class="bg-surface border border-line rounded-md p-8 text-center">
        <p class="text-ink/50 text-sm mb-3">Kamu belum pernah membuat laporan.</p>
        <a href="/tickets/create" class="text-primary hover:underline text-sm font-medium">Buat laporan pertamamu →</a>
    </div>
<?php else: ?>
    <div class="bg-surface border border-line rounded-md overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-canvas border-b border-line">
                <tr class="font-mono text-xs uppercase tracking-wide text-ink/50">
                    <th class="px-4 py-3 font-medium">Judul</th>
                    <th class="px-4 py-3 font-medium">Kategori</th>
                    <th class="px-4 py-3 font-medium">Status</th>
                    <th class="px-4 py-3 font-medium">Dibuat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-line">
                <?php foreach ($recentTickets as $t): ?>
                    <?php
                        $statusClass = [
                            'open'        => 'bg-open-soft text-open',
                            'in_progress' => 'bg-progress-soft text-progress',
                            'closed'      => 'bg-closed-soft text-closed',
                        ][$t['status']];
                    ?>
                    <tr class="hover:bg-canvas/60 transition">
                        <td class="px-4 py-3 font-medium"><?= esc($t['judul']) ?></td>
                        <td class="px-4 py-3 text-ink/70"><?= esc($t['kategori']) ?></td>
                        <td class="px-4 py-3">
                            <span class="font-mono text-xs px-2 py-1 rounded-sm <?= $statusClass ?>">
                                [ <?= strtoupper(esc($t['status'])) ?> ]
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono text-xs text-ink/50"><?= esc($t['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-3 text-right">
        <a href="/tickets" class="text-primary hover:underline text-sm">Lihat semua laporan →</a>
    </div>
<?php endif; ?>

<?= $this->include('partials/footer') ?>