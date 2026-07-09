<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Saya - SIGAP</title>
</head>
<body>

    <h1>Riwayat Laporan Saya</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>

    <p><a href="/tickets/create">+ Buat Laporan Baru</a> | <a href="/dashboard">Dashboard</a></p>

    <?php if (empty($tickets)): ?>
        <p>Belum ada laporan.</p>
    <?php else: ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Dibuat</th>
            </tr>
            <?php foreach ($tickets as $t): ?>
                <tr>
                    <td><?= esc($t['judul']) ?></td>
                    <td><?= esc($t['kategori']) ?></td>
                    <td><?= esc($t['status']) ?></td>
                    <td><?= esc($t['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

</body>
</html>