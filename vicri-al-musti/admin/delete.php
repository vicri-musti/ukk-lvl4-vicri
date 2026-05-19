<?php
session_start();
include __DIR__ . '/../koneksi.php'; // PERBAIKAN PATH KONEKSI

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    mysqli_query($koneksi, "DELETE FROM alumni WHERE id = $id");

    mysqli_query($koneksi, "SET @num := 0");
    mysqli_query($koneksi, "UPDATE alumni SET id = @num := @num + 1 ORDER BY id");
    mysqli_query($koneksi, "ALTER TABLE alumni AUTO_INCREMENT = 1");
}

header("Location: dashboard.php"); // Tetap mengarah ke dashboard.php karena satu folder
exit();
?>