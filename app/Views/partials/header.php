<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'SIGAP' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
</head>
<body class="bg-canvas text-ink font-sans">

<?php $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>
<?php
    function navActive($current, $target) {
        return strpos($current, $target) === 0
            ? 'bg-white/10 text-white'
            : 'text-white/60 hover:bg-white/5 hover:text-white';
    }
?>

<div class="flex min-h-screen">

    <aside class="w-60 shrink-0 bg-primary text-white flex flex-col h-screen sticky top-0">

        <div class="px-5 py-6 border-b border-white/10">
            <p class="font-mono font-semibold tracking-wide"> SIGAP </p>
            <p class="text-xs text-white/40 mt-1">IT Helpdesk Internal</p>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-1 text-sm">
    <?php if (session()->get('role') === 'admin'): ?>

        <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-md transition <?= navActive($path, '/admin/dashboard') ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
            Dashboard
        </a>
        <a href="/admin/users" class="flex items-center gap-3 px-3 py-2 rounded-md transition <?= navActive($path, '/admin/users') ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Kelola User
        </a>

    <?php else: ?>

        <a href="/dashboard" class="flex items-center gap-3 px-3 py-2 rounded-md transition <?= navActive($path, '/dashboard') ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/></svg>
            Dashboard
        </a>
        <a href="/tickets/create" class="flex items-center gap-3 px-3 py-2 rounded-md transition <?= navActive($path, '/tickets/create') ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/></svg>
            Buat Laporan
        </a>
        <a href="/tickets" class="flex items-center gap-3 px-3 py-2 rounded-md transition <?= ($path === '/tickets') ? 'bg-white/10 text-white' : 'text-white/60 hover:bg-white/5 hover:text-white' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/><path d="M9 12h6M9 16h6"/></svg>
            Riwayat Laporan
        </a>

    <?php endif; ?>
</nav>

        <div class="px-4 py-4 border-t border-white/10">
            <p class="text-sm font-medium truncate"><?= esc(session()->get('username')) ?></p>
            <p class="font-mono text-xs text-white/40 uppercase mb-3"><?= esc(session()->get('role')) ?></p>
            <a href="/logout" class="flex items-center gap-2 text-xs font-mono uppercase tracking-wide text-white/50 hover:text-white transition">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5M21 12H9"/></svg>
                Logout
            </a>
        </div>

    </aside>

    <main class="flex-1 p-8 min-w-0">