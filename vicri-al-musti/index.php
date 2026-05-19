<?php
session_start();

// cek apakah sudah login
if (isset($_SESSION['role'])) {

    // tentukan arah halaman berdasarkan role jika sudah login
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard.php");
        exit();
    } else if ($_SESSION['role'] == 'user') {
        header("Location: user.php");
        exit();
    }
} else {
    // jika blm login, diarahkan ke halaman login
    header("Location: auth/login.php");
    exit();
}
?>