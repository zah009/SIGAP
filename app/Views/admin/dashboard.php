<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - SIGAP</title>
</head>
<body>

    <h1>Dashboard Admin</h1>
    <p><a href="/logout">Logout</a></p>

    <p>
        Open: <?= $summary['open'] ?> |
        In Progress: <?= $summary['in_progress'] ?> |
        Closed: <?= $summary['closed'] ?>
    </p>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('success')) ?></p>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Dibuat</th><th>Aksi</th>
        </tr>
        <?php $no = 1; ?>
        <?php foreach ($tickets as $t): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($t['judul']) ?></td>
                <td><?= esc($t['kategori']) ?></td>
                <td><?= esc($t['status']) ?></td>
                <td><?= esc($t['created_at']) ?></td>
                <td><a href="/admin/tickets/<?= $t['id'] ?>">Detail</a></td>
            </tr>
    <?php endforeach; ?>
    </table>

</body>
</html>