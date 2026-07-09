<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Tiket - SIGAP</title>
</head>
<body>

    <p><a href="/admin/dashboard">← Kembali</a></p>

    <h1><?= esc($ticket['judul']) ?></h1>
    <p>Kategori: <?= esc($ticket['kategori']) ?> | Status saat ini: <strong><?= esc($ticket['status']) ?></strong></p>
    <p><?= esc($ticket['deskripsi']) ?></p>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <h3>Update Status</h3>
    <form action="/admin/tickets/<?= $ticket['id'] ?>/update" method="post">
        <?= csrf_field() ?>
        <select name="status">
            <option value="open" <?= $ticket['status'] === 'open' ? 'selected' : '' ?>>Open</option>
            <option value="in_progress" <?= $ticket['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="closed" <?= $ticket['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
        </select><br><br>
        <textarea name="catatan" placeholder="Catatan penanganan (wajib diisi)" rows="3" style="width:300px;"></textarea><br><br>
        <button type="submit">Update</button>
    </form>

    <h3>Riwayat Penanganan</h3>
    <?php if (empty($logs)): ?>
        <p>Belum ada catatan.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($logs as $log): ?>
                <li><?= esc($log['created_at']) ?> — <?= esc($log['catatan']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</body>
</html>