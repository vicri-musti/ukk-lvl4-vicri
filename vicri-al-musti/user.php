<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Alumni Hub</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            overflow-x: hidden;
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .dark-mode {
            filter: grayscale(100%);
            background: #0f172a !important;
        }

        .floating {
            animation: floating 4s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .gradient-bg {
            background: linear-gradient(-45deg,
                    #0f172a,
                    #1e293b,
                    #312e81,
                    #7f1d1d);
            background-size: 400% 400%;
            animation: gradient 12s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>

<body id="body-layout"
    class="gradient-bg min-h-screen text-white font-sans transition-all duration-500">

    <!-- Background Blur -->
    <div class="fixed inset-0 overflow-hidden -z-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-red-500/20 blur-3xl rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-indigo-500/20 blur-3xl rounded-full"></div>
    </div>

    <!-- Navbar -->
    <header class="sticky top-0 z-50 px-6 py-4">
        <nav class="glass rounded-3xl px-6 py-4 flex justify-between items-center shadow-2xl">

            <div>
                <h1 class="text-2xl font-black tracking-wide">
                    Alumni Hub
                </h1>

                <p class="text-xs text-slate-300">
                    Dashboard User
                </p>
            </div>

            <div class="flex items-center gap-4">

                <button id="theme-toggle"
                    class="glass px-4 py-2 rounded-2xl text-sm font-bold hover:scale-105 transition-all">
                    <span id="theme-text">Hitam Putih</span>
                </button>

                <div class="hidden md:flex items-center gap-2 glass px-4 py-2 rounded-2xl">
                    <span>👤</span>
                    <span class="text-sm font-semibold">
                        <?= htmlspecialchars($_SESSION['username']) ?>
                    </span>
                </div>

                <a href="logout.php"
                    class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-2xl font-bold text-sm transition-all shadow-lg hover:scale-105">
                    Logout
                </a>

            </div>
        </nav>
    </header>

    <main class="p-6 max-w-7xl mx-auto">

        <!-- Welcome -->
        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <div class="lg:col-span-2 glass rounded-3xl p-8 shadow-2xl">

                <h2 class="text-3xl font-black mb-3">
                    Selamat Datang 👋
                </h2>

                <p class="text-slate-300 leading-relaxed">
                    Gunakan dashboard ini untuk mencari data alumni,
                    melihat program studi, dan memantau informasi alumni sekolah.
                </p>

            </div>

            <!-- Statistik -->
            <div class="glass rounded-3xl p-8 shadow-2xl relative overflow-hidden">

                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>

                <p class="text-sm uppercase tracking-widest text-slate-300">
                    Total Alumni
                </p>

                <div class="mt-4 flex items-end gap-3">
                    <h1 class="text-5xl font-black floating">
                        <?= $total_alumni ?>
                    </h1>

                    <span class="text-slate-300 mb-2">
                        Data
                    </span>
                </div>

            </div>

        </section>

        <!-- Search -->
        <section class="glass rounded-3xl p-6 shadow-2xl mb-8">

            <form method="GET"
                class="flex flex-col md:flex-row gap-4">

                <input type="text"
                    name="cari"
                    placeholder="Cari nama alumni, jurusan, atau angkatan..."
                    value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>"
                    class="flex-1 px-5 py-4 rounded-2xl bg-white/10 border border-white/10 text-white placeholder-slate-300 outline-none focus:ring-4 focus:ring-red-500/30">

                <button type="submit"
                    class="bg-white text-slate-900 font-black px-8 py-4 rounded-2xl hover:scale-105 transition-all">
                    Cari
                </button>

                <?php if (isset($_GET['cari']) && $_GET['cari'] != ''): ?>
                    <a href="user.php"
                        class="bg-red-600 px-6 py-4 rounded-2xl font-bold text-center hover:bg-red-700 transition-all">
                        Reset
                    </a>
                <?php endif; ?>

            </form>

        </section>

        <!-- Table -->
        <section class="glass rounded-3xl overflow-hidden shadow-2xl">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>
                        <tr class="border-b border-white/10 text-left text-sm uppercase tracking-wider text-slate-300">

                            <th class="px-6 py-5 text-center">
                                No
                            </th>

                            <th class="px-6 py-5">
                                Nama Lengkap
                            </th>

                            <th class="px-6 py-5">
                                Angkatan
                            </th>

                            <th class="px-6 py-5">
                                Program Studi
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $no = 1;

                        if (isset($_GET['cari']) && $_GET['cari'] != '') {
                            $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);

                            $query = "SELECT * FROM alumni 
                                      WHERE nama_lengkap LIKE '%$cari%'
                                      OR angkatan LIKE '%$cari%'
                                      OR jurusan LIKE '%$cari%'";
                        } else {
                            $query = "SELECT * FROM alumni";
                        }

                        $result = mysqli_query($koneksi, $query);

                        if (mysqli_num_rows($result) > 0) {

                            while ($data = mysqli_fetch_assoc($result)) {

                                echo "
                                <tr class='border-b border-white/5 hover:bg-white/5 transition-all'>

                                    <td class='px-6 py-5 text-center text-slate-300 font-bold'>
                                        $no
                                    </td>

                                    <td class='px-6 py-5 font-bold'>
                                        {$data['nama_lengkap']}
                                    </td>

                                    <td class='px-6 py-5'>
                                        <span class='bg-white/10 px-3 py-1 rounded-xl text-sm'>
                                            {$data['angkatan']}
                                        </span>
                                    </td>

                                    <td class='px-6 py-5 text-slate-300'>
                                        {$data['jurusan']}
                                    </td>

                                </tr>
                                ";

                                $no++;
                            }

                        } else {

                            echo "
                            <tr>
                                <td colspan='4'
                                    class='text-center py-16 text-slate-300'>
                                    Data alumni tidak ditemukan.
                                </td>
                            </tr>
                            ";
                        }
                        ?>

                    </tbody>

                </table>

            </div>

        </section>

    </main>

    <!-- Theme -->
    <script>
        const bodyLayout = document.getElementById('body-layout');
        const themeToggle = document.getElementById('theme-toggle');
        const themeText = document.getElementById('theme-text');

        if (localStorage.getItem('theme') === 'darkmono') {
            enableMono();
        }

        themeToggle.addEventListener('click', () => {

            if (localStorage.getItem('theme') === 'darkmono') {
                disableMono();
            } else {
                enableMono();
            }

        });

        function enableMono() {
            bodyLayout.classList.add('dark-mode');
            themeText.innerText = "Mode Warna";
            localStorage.setItem('theme', 'darkmono');
        }

        function disableMono() {
            bodyLayout.classList.remove('dark-mode');
            themeText.innerText = "Hitam Putih";
            localStorage.setItem('theme', 'color');
        }
    </script>

</body>

</html>