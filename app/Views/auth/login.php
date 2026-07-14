<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIGAP</title>
    <link href="/assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-sm rounded-lg p-8 w-full max-w-sm border border-gray-100">
        <h1 class="text-2xl font-bold text-blue-700 mb-1 text-center">SIGAP</h1>
        <p class="text-sm text-gray-500 mb-6 text-center">Sistem Informasi Gangguan &amp; Aduan Pengguna</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-50 text-red-700 text-sm px-4 py-2 rounded-md mb-4">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form action="/login" method="post">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       value="<?= esc(old('username')) ?>">
            </div>

            <div class="mb-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="text-right mb-6">
                <a href="/forgot-password" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-md text-sm transition">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>