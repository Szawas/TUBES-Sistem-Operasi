<?php
// Hubungkan ke database
require 'db.php';

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    // Query untuk memasukkan data pesan
    $sql = "INSERT INTO messages (nama, email, no_hp) VALUES ('$nama', '$email', '$no_hp')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Pesan berhasil dikirim!";
    } else {
        $error_message = "Terjadi kesalahan: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Pesan</title>
</head>

<body>
    <h1>Kirim Pesan</h1>
    <?php if (isset($success_message)): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php elseif (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form action="send_message.php" method="POST">
        <input type="text" name="nama" placeholder="Nama" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="no_hp" placeholder="No HP" required><br>
        <button type="submit">Kirim Pesan</button>
    </form>
</body>

</html>