<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Tiket - SIGAP</title>
</head>
<body>

    <h1>Buat Laporan Gangguan</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <ul style="color:red;">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="/tickets/store" method="post">
        <?= csrf_field() ?>

        <label>Kategori</label><br>
        <select name="kategori">
            <option value="hardware">Hardware</option>
            <option value="software">Software</option>
            <option value="jaringan">Jaringan</option>
            <option value="akun">Akun/Akses</option>
        </select><br><br>

        <label>Judul</label><br>
        <input type="text" name="judul" value="<?= esc(old('judul')) ?>"><br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="5"><?= esc(old('deskripsi')) ?></textarea><br><br>

        <button type="submit">Kirim Laporan</button>
    </form>

    <p><a href="/dashboard">Kembali</a></p>

</body>
</html>