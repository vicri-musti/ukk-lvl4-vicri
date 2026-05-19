<?php
session_start();
include __DIR__ . '/../koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ./auth/login.php");
    exit();
}

$status_simpan = "";

if (isset($_POST['simpan'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $angkatan = mysqli_real_escape_string($koneksi, $_POST['angkatan']);
    $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);

    $sql = "INSERT INTO alumni (nama_lengkap, angkatan, jurusan) VALUES ('$nama', '$angkatan', '$jurusan')";
    
    if (mysqli_query($koneksi, $sql)) {
        $status_simpan = "sukses";
    } else {
        $status_simpan = "gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - Premium Alumni Core</title>
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
    </style>
</head>
<body id="body-layout" class="bg-gradient-to-br from-slate-50 via-slate-100 to-indigo-50/50 text-slate-800 min-h-full font-sans transition-all duration-500 flex flex-col justify-center items-center p-4">

    <div class="absolute top-5 right-5 z-50">
        <button id="theme-toggle" class="bg-slate-900 text-white text-xs font-bold py-2.5 px-4 rounded-xl border border-slate-800 cursor-pointer transition-all shadow-md">
            <span id="theme-text">Hitam-Putih</span>
        </button>
    </div>

    <main class="w-full max-w-xl">
        <div class="mb-5">
            <a href="./dashboard.php" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-900 transition-colors">
                <span>← Kembali ke Dashboard</span>
            </a>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-200/60 relative overflow-hidden transition-all">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-6">Tambah Data Alumni</h2>
            
            <form action="" method="post" class="flex flex-col gap-5">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider pl-0.5">Nama Lengkap</label>
                    <input type="text" name="nama" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-all">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider pl-0.5">Tahun Lulus</label>
                    <input type="number" name="angkatan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-all">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider pl-0.5">Jurusan</label>
                    <select name="jurusan" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-slate-900 focus:bg-white transition-all cursor-pointer">
                        <option value="" disabled selected>Pilih Jurusan</option>
                        <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                        <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                        <option value="Teknik Jaringan Akses Telekomunikasi">Teknik Jaringan Akses Telekomunikasi</option>
                        <option value="Animasi">Animasi</option>
                    </select>
                </div>

                <div class="mt-2">
                    <button type="submit" name="simpan" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm py-3.5 px-4 rounded-xl shadow-md transition-all cursor-pointer">
                        Simpan Data Alumni
                    </button>
                </div>

                <?php if ($status_simpan == "sukses"): ?>
                    <div class="mt-2 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-sm font-semibold flex items-center justify-between">
                        <span>Berhasil menyimpan data!</span>
                        <a href="./dashboard.php" class="bg-slate-900 text-white px-3 py-1.5 rounded-lg font-bold">Lihat Tabel</a>
                    </div>
                <?php elseif ($status_simpan == "gagal"): ?>
                    <div class="mt-2 p-4 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 text-sm font-semibold">
                        Gagal menyimpan data!
                    </div>
                <?php endif; ?>
            </form>
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