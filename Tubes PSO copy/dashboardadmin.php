<?php
session_start();
require 'db.php';

// Periksa apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Menambah menu baru
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_menu'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_POST['gambar']; // Misalnya, Anda ingin menyimpan URL gambar

    // Query untuk menambahkan menu ke database
    $query = "INSERT INTO menu (nama, harga, gambar) VALUES ('$nama', '$harga', '$gambar')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $success_message = "Menu berhasil ditambahkan!";
    } else {
        $error_message = "Terjadi kesalahan saat menambahkan menu.";
    }
}

// Mengedit menu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_menu'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_POST['gambar'];

    // Query untuk mengupdate menu
    $query = "UPDATE menu SET nama = '$nama', harga = '$harga', gambar = '$gambar' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $success_message = "Menu berhasil diperbarui!";
    } else {
        $error_message = "Terjadi kesalahan saat memperbarui menu.";
    }
}

// Menghapus menu
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    // Query untuk menghapus menu
    $query = "DELETE FROM menu WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $success_message = "Menu berhasil dihapus!";
    } else {
        $error_message = "Terjadi kesalahan saat menghapus menu.";
    }
}

// Menampilkan menu
$query = "SELECT * FROM menu";
$menus = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        :root {
            --primary: #b6895b;
            /* Warna utama */
            --bg: #010101;
            /* Warna latar belakang */
            --text-light: #fff;
            /* Warna teks terang */
            --text-dark: #333;
            /* Warna teks gelap */
            --border-color: #513c28;
            /* Warna border */
            --input-bg: #222;
            /* Latar belakang input */
            --input-border: #eee;
            /* Warna border input */
        }

        body {
            background-color: var(--bg);
            color: var(--text-light);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: var(--primary);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-logo {
            color: var(--text-light);
            font-size: 24px;
            font-weight: bold;
        }

        .navbar-nav a {
            color: var(--text-light);
            margin: 0 10px;
            text-decoration: none;
        }

        .navbar-nav a:hover {
            text-decoration: underline;
        }

        #admin-dashboard {
            padding: 30px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 22px;
            margin-bottom: 15px;
        }

        form input {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--text-light);
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            font-size: 16px;
        }

        form button {
            background-color: var(--primary);
            border: none;
            color: var(--text-light);
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #a77d49;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        table th {
            background-color: var(--primary);
            color: var(--text-light);
        }

        table td a {
            color: var(--primary);
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid var(--primary);
            border-radius: 5px;
            margin-right: 5px;
        }

        table td a:hover {
            background-color: var(--primary);
            color: var(--text-light);
        }

        .message {
            margin: 20px 0;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #4CAF50;
            color: white;
        }

        .error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="#" class="navbar-logo">Kopi<span>Senja</span></a>
        <div class="navbar-nav">
            <a href="#">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#menu">Menu</a>
            <a href="#contact">Kontak</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <section id="admin-dashboard">
        <h2>Dashboard Admin - Menu</h2>

        <!-- Form tambah menu -->
        <form action="" method="POST">
            <h3>Tambah Menu</h3>
            <input type="text" name="nama" placeholder="Nama Menu" required>
            <input type="text" name="harga" placeholder="Harga Menu" required>
            <input type="text" name="gambar" placeholder="URL Gambar" required>
            <button type="submit" name="add_menu">Tambah Menu</button>
        </form>

        <?php if (isset($success_message)) {
            echo "<div class='message success'>$success_message</div>";
        } ?>
        <?php if (isset($error_message)) {
            echo "<div class='message error'>$error_message</div>";
        } ?>

        <!-- Daftar menu -->
        <h3>Daftar Menu</h3>
        <table>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
            <?php while ($menu = mysqli_fetch_assoc($menus)): ?>
                <tr>
                    <td><?php echo $menu['nama']; ?></td>
                    <td><?php echo $menu['harga']; ?></td>
                    <td><img src="<?php echo $menu['gambar']; ?>" alt="Gambar Menu" width="100"></td>
                    <td>
                        <!-- Edit button -->
                        <a href="edit_menu.php?id=<?php echo $menu['id']; ?>">Edit</a> |
                        <!-- Delete button -->
                        <a href="?delete_id=<?php echo $menu['id']; ?>"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

</body>

</html>