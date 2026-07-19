<?= $this->include('partials/header', ['title' => 'Detail Tiket - SIGAP']) ?>

<a href="/admin/dashboard" class="text-sm text-blue-600 hover:underline">← Kembali</a>

<div class="bg-white rounded-lg shadow-sm p-6 mt-4 mb-6">
    <h1 class="text-2xl font-bold mb-1"><?= esc($ticket['judul']) ?></h1>
    <p class="text-sm text-gray-500 mb-4">
        Kategori: <?= esc($ticket['kategori']) ?> |
        Status saat ini: <strong><?= esc($ticket['status']) ?></strong>
    </p>
    <p class="text-sm text-gray-500 mb-4">
        Pelapor: <strong><?= esc($ticket['nama_lengkap'] ?? '-') ?></strong>
        <?php if (!empty($ticket['username'])): ?>
            (<?= esc($ticket['username']) ?>)
        <?php endif; ?>
        <?php if (!empty($ticket['reporter_email'])): ?>
            — <?= esc($ticket['reporter_email']) ?>
        <?php endif; ?>
    </p>
    <p class="text-gray-700"><?= esc($ticket['deskripsi']) ?></p>
    <?php if (!empty($ticket['lampiran'])): ?>
    <p class="mt-3">
        <a href="/uploads/tickets/<?= esc($ticket['lampiran']) ?>" target="_blank" class="text-primary hover:underline text-sm">
            📎 Lihat Lampiran
        </a>
    </p>
    <?php endif; ?>

    <?php if ($ticket['status'] === 'in_progress' && !empty($ticket['sla_deadline'])): ?>
        <p class="text-sm mt-4 pt-4 border-t border-gray-100">
            Target penyelesaian (<?= $ticket['sla_hours'] ?> jam):
            <strong class="sla-countdown font-mono" data-deadline="<?= strtotime($ticket['sla_deadline']) ?>">menghitung...</strong>
        </p>
    <?php elseif ($ticket['status'] === 'closed' && !empty($ticket['sla_deadline'])): ?>
        <?php $onTime = strtotime($ticket['updated_at']) <= strtotime($ticket['sla_deadline']); ?>
        <p class="text-sm mt-4 pt-4 border-t border-gray-100">
            SLA <?= $ticket['sla_hours'] ?> jam —
            <span class="<?= $onTime ? 'text-green-600' : 'text-red-600' ?> font-medium">
                <?= $onTime ? 'Selesai tepat waktu' : 'Selesai melewati batas waktu' ?>
            </span>
        </p>
    <?php endif; ?>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <p class="text-red-600 text-sm mb-4"><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>

<div class="bg-white rounded-lg shadow-sm p-6 mb-6">
    <h3 class="font-semibold mb-3">Update Status</h3>
    <form action="/admin/tickets/<?= $ticket['id'] ?>/update" method="post">
        <?= csrf_field() ?>

        <select name="status" id="statusSelect" class="border border-gray-300 rounded-md px-3 py-2 text-sm mb-3">
            <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
            <option value="in_progress" <?= $ticket['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
        </select>

        <div id="slaField" class="mb-3" style="display:none;">
            <label class="block text-sm font-medium mb-1">Estimasi Penyelesaian (jam)</label>
            <input type="number" name="sla_hours" min="1" class="border border-gray-300 rounded-md px-3 py-2 text-sm w-32" placeholder="misal: 48">
        </div>

        <textarea name="catatan" placeholder="Catatan penanganan (wajib diisi)" rows="3"
                  class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm mb-3"></textarea>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-md transition">
            Update
        </button>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm p-6">
    <h3 class="font-semibold mb-3">Riwayat Penanganan</h3>
    <?php if (empty($logs)): ?>
        <p class="text-gray-500 text-sm">Belum ada catatan.</p>
    <?php else: ?>
        <ul class="space-y-2">
            <?php foreach ($logs as $log): ?>
                <li class="text-sm border-l-2 border-blue-400 pl-3">
                    <span class="text-gray-400"><?= esc($log['created_at']) ?></span> — <?= esc($log['catatan']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var statusSelect = document.getElementById('statusSelect');
    var slaField = document.getElementById('slaField');
    function toggleSla() {
        slaField.style.display = statusSelect.value === 'in_progress' ? 'block' : 'none';
    }
    statusSelect.addEventListener('change', toggleSla);
    toggleSla();
});
</script>

<?= $this->include('partials/footer') ?>