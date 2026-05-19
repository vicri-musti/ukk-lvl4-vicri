<?php
$password_admin = "admin123"; 

// Fungsi bawaan PHP untuk enkripsi password (Bcrypt)
$hash_password = password_hash($password_admin, PASSWORD_DEFAULT);

echo "<h3>Generator Hash Password</h3>";
echo "Password Asli: <b>" . $password_admin . "</b><br><br>";
echo "Copy teks di bawah ini dan paste ke kolom password di phpMyAdmin:<br><br>";

// Menampilkan hasil Hash dengan kotak agar mudah di-copy
echo "<textarea rows='3' cols='70' readonly>" . $hash_password . "</textarea>";
?>