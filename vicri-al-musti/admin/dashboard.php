<?php
session_start();
include __DIR__ . '/../koneksi.php'; // Naik 1 folder untuk mencari koneksi.php

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php"); // Mengarah ke folder auth
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Premium Edition</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .dark-mode-monochrome {
            filter: grayscale(100%) contrast(105%);
            background: #121212 !important;
        }
        .dark-mode-monochrome .bg-white {
            background-color: #1e1e1e !important;
            color: #ffffff !important;
            border-color: #333333 !important;
        }
        .dark-mode-monochrome text, .dark-mode-monochrome p, .dark-mode-monochrome h1, .dark-mode-monochrome h2, .dark-mode-monochrome th {
            color: #e0e0e0 !important;
        }
        .dark-mode-monochrome td {
            color: #cccccc !important;
            border-color: #2a2a2a !important;
        }
        .dark-mode-monochrome .bg-slate-50 {
            background-color: #252525 !important;
        }
    </style>
</head>
<body id="body-layout" class="bg-gradient-to-br from-slate-50 via-slate-100 to-indigo-50/50 text-slate-800 min-h-full font-sans transition-all duration-500 flex flex-col">

    <header>
        <nav class="fixed top-0 left-0 w-full bg-slate-900/90 text-white py-4 px-4 shadow-xl z-50 backdrop-blur-xl border-b border-white/5">
            <div class="container mx-auto max-w-7xl flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <h1 class="text-lg font-black tracking-wider uppercase">Alumni Core</h1>
                    <span class="bg-white/10 px-2.5 py-0.5 rounded-md text-[9px] font-bold tracking-widest uppercase border border-white/10">Admin v2.0</span>
                </div>
                <div class="flex items-center gap-4">
                    <button id="theme-toggle" class="bg-white/10 hover:bg-white/20 text-xs font-bold py-2 px-3 rounded-xl border border-white/10 cursor-pointer transition-all">
                        <span id="theme-text">Hitam-Putih</span>
                    </button>
                    <span class="hidden sm:inline-block bg-white text-slate-900 text-xs font-black py-2 px-4 rounded-xl shadow-inner">⚡ <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <a href="../logout.php" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-xl transition-all shadow-md">Keluar</a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto max-w-7xl pt-28 pb-12 px-4 flex-1">
        
        <div class="bg-white p-5 rounded-2xl shadow-xl border border-slate-200/60 mb-6 flex flex-col md:flex-row justify-between items-center gap-4 transition-all">
            <form method="GET" class="flex items-center gap-2 flex-1 w-full md:max-w-xl">
                <input type="text" name="cari" placeholder="Cari data alumni..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-slate-900 focus:bg-white transition-all">
                <button type="submit" class="bg-slate-900 text-white font-bold text-sm px-6 py-2.5 rounded-xl cursor-pointer hover:bg-slate-800 transition-colors">Cari</button>
                <?php if (isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                    <a href="dashboard.php" class="bg-slate-100 p-2.5 rounded-xl border border-slate-200 text-xs font-bold">Reset</a>
                <?php endif; ?>
            </form>
            <a href="create.php" class="w-full md:w-auto text-center bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-2.5 px-6 rounded-xl shadow-lg transition-all">Tambah Alumni</a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden transition-all">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-400 uppercase tracking-widest">
                            <th class="px-6 py-4 text-center w-20">ID</th>
                            <th class="px-6 py-4">Nama Lengkap</th>
                            <th class="px-6 py-4">Angkatan</th>
                            <th class="px-6 py-4">Program Studi</th>
                            <th class="px-6 py-4 text-center w-40">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php
                        $no = 1;
                        if (isset($_GET['cari']) && $_GET['cari'] != '') {
                            $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
                            $query = "SELECT * FROM alumni WHERE nama_lengkap LIKE '%$cari%' OR angkatan LIKE '%$cari%' OR jurusan LIKE '%$cari%'";
                        } else {
                            $query = "SELECT * FROM alumni";
                        }
                        
                        $result = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                echo "<tr class='text-sm text-slate-700 hover:bg-slate-50/80 transition-all'>
                                    <td class='px-6 py-4 text-center font-bold text-slate-400'>$no</td>
                                    <td class='px-6 py-4 font-bold text-slate-900'>{$data['nama_lengkap']}</td>
                                    <td class='px-6 py-4'><span class='bg-slate-100 text-slate-800 text-xs px-2.5 py-1 rounded-md font-bold border border-slate-200/40'>Kelas {$data['angkatan']}</span></td>
                                    <td class='px-6 py-4 font-medium text-slate-500'>{$data['jurusan']}</td>
                                    <td class='px-6 py-4 text-center'>
                                        <div class='flex justify-center gap-2'>
                                            <a href='update.php?id={$data['id']}' class='text-xs font-bold bg-slate-100 text-slate-700 py-1.5 px-3 rounded-lg border border-slate-200 hover:bg-slate-200 transition-colors'>Edit</a>
                                            <a href='delete.php?id={$data['id']}' onclick=\"return confirm('Hapus data alumni ini?')\" class='text-xs font-bold bg-red-50 text-red-600 py-1.5 px-3 rounded-lg border border-red-100 hover:bg-red-100 transition-colors'>Hapus</a>
                                        </div>
                                    </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' class='p-12 text-center text-slate-400 text-sm font-medium'>Belum ada rekam data alumni atau pencarian tidak ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const themeText = document.getElementById('theme-text');
        const bodyLayout = document.getElementById('body-layout');

        if (localStorage.getItem('theme') === 'monochrome') { enableMonochrome(); }
        themeToggle.addEventListener('click', () => {
            if (localStorage.getItem('theme') !== 'monochrome') { enableMonochrome(); } else { disableMonochrome(); }
        });
        function enableMonochrome() {
            bodyLayout.classList.add('dark-mode-monochrome');
            themeText.innerText = "Mode Berwarna";
            localStorage.setItem('theme', 'monochrome');
        }
        function disableMonochrome() {
            bodyLayout.classList.remove('dark-mode-monochrome');
            themeText.innerText = "Hitam-Putih";
            localStorage.setItem('theme', 'colored');
        }
    </script>
</body>
</html>