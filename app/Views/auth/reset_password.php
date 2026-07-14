<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SIGAP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-canvas min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white shadow-sm rounded-lg p-8 w-full max-w-sm border border-line">
        <h1 class="text-2xl font-bold text-primary mb-1 font-mono">[ SIGAP ]</h1>
        <p class="text-sm text-ink/50 mb-6">Buat password baru</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-open-soft text-open text-sm px-4 py-2 rounded-md mb-4">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="/reset-password" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <div class="mb-4">
                <label class="block text-sm font-medium text-ink/70 mb-1">Password Baru</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full border border-line rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-ink/70 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirm" required minlength="8"
                       class="w-full border border-line rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-hover text-white font-medium py-2 rounded-md text-sm transition">
                Simpan Password Baru
            </button>
        </form>
    </div>

</body>
</html>