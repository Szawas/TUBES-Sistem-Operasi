<?php
$host = 'srv1410.hstgr.io'; // Host database
$db = 'u740202808_FunProject'; // Nama database
$user = 'u740202808_RootFunProject'; // Username
$pass = '!@funPRO34'; // Password

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Jika berhasil
    echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Jika gagal
    echo "Koneksi gagal: " . $e->getMessage();
}
?>