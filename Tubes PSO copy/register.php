<?php
session_start();
include('db.php'); // Koneksi database

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email']; // Menambahkan email
    $role = $_POST['role']; // Pastikan role sudah dipilih (admin atau user)

    // Cek apakah username sudah terdaftar
    $query = "SELECT * FROM users WHERE username = ? OR email = ?"; // Menambahkan cek email
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $username, $email); // Binding username dan email
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = 'Username atau email sudah terdaftar.';
    } else {
        // Enkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data ke database
        $query = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssss', $username, $hashed_password, $email, $role);
        $stmt->execute();

        // Redirect ke halaman login
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kopi Senja</title>
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

        /* Reset gaya bawaan browser */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Container utama untuk form register */
        .register-container {
            background: var(--input-bg);
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .register-container h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .register-container p {
            margin-bottom: 15px;
        }

        .register-container p a {
            color: var(--primary);
            text-decoration: none;
        }

        .register-container p a:hover {
            text-decoration: underline;
        }

        /* Grup input */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid var(--input-border);
            border-radius: 5px;
            background: var(--bg);
            color: var(--text-light);
            transition: all 0.3s ease-in-out;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 5px rgba(182, 137, 91, 0.5);
        }

        /* Tombol Daftar */
        button {
            width: 100%;
            padding: 12px 20px;
            background: var(--primary);
            color: var(--text-light);
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background: #8f6d47;
        }

        /* Responsivitas */
        @media (max-width: 480px) {
            .register-container {
                padding: 20px 15px;
            }

            .register-container h2 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Daftar Akun</h2>
        <?php if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        } ?>
        <form action="" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required> <!-- Menambahkan input email -->
            </div>
            <div class="input-group">
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>

</html>