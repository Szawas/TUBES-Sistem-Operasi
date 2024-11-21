<?php
session_start();
include('db.php'); // Koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengecek username dan password
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil, set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect sesuai role
            if ($user['role'] == 'admin') {
                header('Location: dashboardadmin.php');
            } else {
                header('Location: dashboarduser.php');
            }
            exit;
        } else {
            $error_message = 'Password salah.';
        }
    } else {
        $error_message = 'Username tidak ditemukan.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kopi Senja</title>
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

        /* Container utama untuk form login */
        .login-container {
            background: var(--input-bg);
            padding: 30px 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
            border: 1px solid var(--border-color);
        }

        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--primary);
        }

        /* Pesan error */
        .login-container p {
            margin-bottom: 15px;
        }

        .login-container p a {
            color: var(--primary);
            text-decoration: none;
        }

        .login-container p a:hover {
            text-decoration: underline;
        }

        /* Grup input */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid var(--input-border);
            border-radius: 5px;
            background: var(--bg);
            color: var(--text-light);
            transition: all 0.3s ease-in-out;
        }

        .input-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 5px rgba(182, 137, 91, 0.5);
        }

        /* Tombol Login */
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
            .login-container {
                padding: 20px 15px;
            }

            .login-container h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
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
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>

</html>