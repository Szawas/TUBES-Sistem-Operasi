<?php
session_start();
require 'db.php';

// Periksa apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data menu untuk diedit
    $query = "SELECT * FROM menu WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $menu = mysqli_fetch_assoc($result);

    if (!$menu) {
        die("Menu tidak ditemukan!");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_menu'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_POST['gambar'];

    // Update menu
    $query = "UPDATE menu SET nama = '$nama', harga = '$harga', gambar = '$gambar' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: dashboardadmin.php");
        exit();
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui menu.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
</head>

<body>

    <h2>Edit Menu</h2>

    <?php if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    } ?>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo $menu['id']; ?>">
        <input type="text" name="nama" value="<?php echo $menu['nama']; ?>" required>
        <input type="text" name="harga" value="<?php echo $menu['harga']; ?>" required>
        <input type="text" name="gambar" value="<?php echo $menu['gambar']; ?>" required>
        <button type="submit" name="edit_menu">Simpan Perubahan</button>
    </form>

</body>

</html>