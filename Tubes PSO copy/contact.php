<?php
include('db.php'); // Koneksi database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    echo "Pesan Anda telah terkirim.";
}
?>
<form method="POST">
    <input type="text" name="name" placeholder="Nama" required>
    <input type="email" name="email" placeholder="Email" required>
    <textarea name="message" placeholder="Pesan Anda"></textarea>
    <button type="submit">Kirim</button>
</form>