<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - SIGAP</title>
</head>
<body>

    <h1>SIGAP - Login</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <form action="/login" method="post">
        <?= csrf_field() ?>

        <label>Username</label><br>
        <input type="text" name="username" value="<?= esc(old('username')) ?>"><br><br>

        <label>Password</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Masuk</button>
    </form>

</body>
</html>