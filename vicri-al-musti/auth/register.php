<?php
session_start();
include __DIR__ . '/../koneksi.php';

// memeriksa btn registrasi telah di tekan(kirim)
if (isset($_POST['registrasi'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // --- BAGIAN YANG DITAMBAHKAN: CEK USERNAME KEMBAR ---
    $cek_user = mysqli_query($koneksi, "SELECT username FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        // Jika username sudah ada, munculkan alert dan batalkan proses insert
        echo "<script>
                alert('Username sudah terdaftar! Silakan gunakan username lain.');
                window.history.back();
              </script>";
        exit(); // Menghentikan baris kode di bawah agar tidak crash
    }
    // ---------------------------------------------------

    // Ini adalah baris 10 Anda yang lama (sekarang aman karena sudah dicek di atas)
    $insert = mysqli_query($koneksi, "INSERT INTO users (username,password,role) VALUES ('$username','$password','user')");

    if ($insert) {
        // jika insert berhasil , langsung set session
        $_SESSION['username'] = $username;
        $_SESSION['role'] = "user";

        header('location: ../user.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Manajemen Data Alumni</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="text-slate-700 min-h-screen flex items-center justify-center font-sans antialiased p-4 relative overflow-hidden bg-slate-100">

    <div class="absolute inset-0 -z-30">
        <div id="bg-slide-1" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-100 scale-105 animate-pulse/subtle"></div>
        <div id="bg-slide-2" class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000 opacity-0 scale-105"></div>
    </div>

    <div class="absolute inset-0 bg-gradient-to-tr from-slate-950/80 via-slate-900/40 to-indigo-950/70 -z-20 backdrop-blur-[3px]"></div>

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-r from-red-500/20 to-indigo-500/20 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <main class="w-full max-w-md relative z-10 transition-all duration-300">

        <form action="register.php" method="post"
            class="bg-white/80 backdrop-blur-2xl p-8 rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.4)] border border-white/60 flex flex-col gap-6 ring-1 ring-black/5">

            <div class="flex flex-col items-center text-center gap-3 mb-1">
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-200 to-rose-200 rounded-full blur-md opacity-40 group-hover:opacity-70 transition-opacity"></div>
                    <img src="../img/logo.png" alt="Logo SMK Telkom" class="relative w-20 h-20 object-contain rounded-full border-2 border-white shadow-md">
                </div>

                <div class="flex flex-col gap-1">
                    <h1 class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 bg-clip-text text-transparent leading-tight">
                        Manajemen Data Alumni
                    </h1>
                    <div>
                        <span class="text-[10px] font-bold tracking-widest uppercase bg-gradient-to-r from-red-500 to-rose-500 text-white px-3 py-1 rounded-full shadow-xs">
                            SMK Telkom Lampung
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider pl-1">Username</label>
                <div class="relative">
                    <input type="text" name="username" placeholder="Masukkan Username"
                        class="w-full px-4 py-3.5 rounded-2xl border border-slate-200/80 bg-slate-50/50 text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition-all duration-300 shadow-inner" required>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-700 uppercase tracking-wider pl-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" placeholder="Masukkan Password"
                        class="w-full px-4 py-3.5 rounded-2xl border border-slate-200/80 bg-slate-50/50 text-slate-900 text-sm placeholder-slate-400 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 transition-all duration-300 shadow-inner" required>
                </div>
            </div>

            <div class="flex flex-col gap-5 mt-2">
                <button type="submit" name="registrasi"
                    class="w-full bg-gradient-to-r from-red-600 via-rose-600 to-red-600 bg-[size:200%_auto] hover:bg-right text-white font-bold py-3.5 px-4 rounded-2xl shadow-xl shadow-red-600/20 active:scale-[0.97] transition-all duration-500 text-sm cursor-pointer text-center tracking-wide">
                    Daftar Sekarang
                </button>

                <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

                <p class="text-xs text-slate-500 text-center font-medium">
                    Sudah punya akun?
                    <a href="login.php" class="text-red-600 font-bold hover:text-indigo-600 hover:underline transition-colors duration-200 ml-1">
                        Masuk disini
                    </a>
                </p>
            </div>

        </form>


    </main>

    <script>
        const images = [
            '../img/bg3.png',
            '../img/bg1.jpg',
            '../img/bg2.jpg'
        ];

        let currentIndex = 0;
        const slide1 = document.getElementById('bg-slide-1');
        const slide2 = document.getElementById('bg-slide-2');

        slide1.style.backgroundImage = `url('${images[0]}')`;
        slide2.style.backgroundImage = `url('${images[1]}')`;

        let isSlide1Active = true;

        function changeBackground() {
            currentIndex = (currentIndex + 1) % images.length;
            const nextImage = images[currentIndex];

            if (isSlide1Active) {
                slide2.style.backgroundImage = `url('${nextImage}')`;
                slide1.classList.replace('opacity-100', 'opacity-0');
                slide2.classList.replace('opacity-0', 'opacity-100');
            } else {
                slide1.style.backgroundImage = `url('${nextImage}')`;
                slide2.classList.replace('opacity-100', 'opacity-0');
                slide1.classList.replace('opacity-0', 'opacity-100');
            }
            isSlide1Active = !isSlide1Active;
        }

        setInterval(changeBackground, 4000);
    </script>
</body>

</html>