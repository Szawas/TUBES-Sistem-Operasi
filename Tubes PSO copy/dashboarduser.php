<?php
session_start();
require 'db.php';

// Periksa apakah pengguna sudah login dan memiliki role 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <!-- Link ke stylesheet -->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kopi Senja</title>
        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">

        <!-- feather -->
        <script src="https://unpkg.com/feather-icons"></script>

        <!-- mystyle -->
        <style>
            :root {
                --primary: #b6895b;
                --bg: #010101;
            }

            * {

                margin: 0;
                padding: 0;
                box-sizing: border-box;
                outline: none;
                border: none;
                text-decoration: none;
            }

            html {
                scroll-behavior: smooth;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: var(--bg);
                color: #fff;
            }

            /* NavBar */

            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1.4rem 7%;
                background-color: rgba(1, 1, 1, 0.8);
                border-bottom: 1px solid #513c28;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 9999;
            }

            .navbar .navbar-logo {
                font-size: 2rem;
                font-weight: 700;
                color: #fff;
                font-style: italic;
            }

            .navbar .navbar-logo span {
                color: var(--primary);
            }

            .navbar .navbar-nav a {
                color: #fff;
                display: inline-block;
                font-size: 1.3rem;
                margin: 0 1rem;
            }

            .navbar .navbar-nav a:hover {
                color: var(--primary);
            }

            .navbar .navbar-nav a::after {
                content: '';
                display: block;
                padding-bottom: 0.5rem;
                border-bottom: 0.1rem solid var(--primary);
                transform: scaleX(0);
                transition: 0.2s linear;
            }

            .navbar .navbar-nav a:hover::after {
                transform: scaleX(0.5);
            }

            .navbar .navbar-extra a {
                color: #fff;
                margin: 0 0.5rem;
            }

            .navbar .navbar-extra a:hover {
                color: var(--primary);
            }

            #hamburger-menu {
                display: none;
            }

            /* Hero Section */
            .hero {
                min-height: 100vh;
                display: flex;
                align-items: center;
                background-image: url('https://unsplash.com/photos/white-ceramic-mug-and-saucer-with-coffee-beans-on-brown-textile-tNALoIZhqVM');
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .hero::after {
                content: '';
                display: block;
                position: absolute;
                width: 100%;
                height: 30%;
                bottom: 0;
                background: linear-gradient(0deg, rgba(1, 1, 3, 1) 8%, rgba(255, 255, 255, 0)50%);
            }

            .hero .content {
                padding: 1.4rem 7%;
                max-width: 60rem;
            }

            .hero .content h1 {
                font-size: 5em;
                color: #fff;
                text-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
                line-height: 1.2;
            }

            .hero .content h1 span {
                color: var(--primary);
            }

            .hero .content p {
                font-size: 1.6rem;
                margin-top: 1rem;
                line-height: 1.4;
                font-weight: 100;
                text-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
                mix-blend-mode: difference;
            }

            .hero .content .cta {
                margin-top: 1rem;
                display: inline-block;
                padding: 1rem 3rem;
                font-size: 1.4rem;
                color: #fff;
                background-color: var(--primary);
                border-radius: 0.5rem;
                box-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
            }

            /* About Section */

            .about,
            .menu,
            .contact {
                padding: 8rem 7% 1.4rem;
            }

            .about h2,
            .menu h2,
            .contact h2 {
                text-align: center;
                font-size: 2.6rem;
                margin-bottom: 3rem;
            }

            .about h2 span,
            .menu h2 span,
            .contact h2 span {
                color: var(--primary);
            }

            .about .row {
                display: flex;
            }

            .about .row .about-img {
                flex: 1 1 45rem;
            }

            .about .row .about-img img {
                width: 100%;
            }

            .about .row .content {
                flex: 1 1 35rem;
                padding: 0 1rem;

            }

            .about .row .content h3 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
            }

            .about .row .content p {
                margin-bottom: 0.8rem;
                font-size: 1.4rem;
                font-weight: 100;
                line-height: 1.6;
            }

            /* Menu Section */
            .menu h2,
            .contact h2 {
                margin-bottom: 1rem;
            }

            .menu p,
            .contact p {
                text-align: center;
                max-width: 30rem;
                margin: auto;
                font-weight: 100;
                line-height: 1.6;
            }

            .menu .row {
                display: flex;
                flex-wrap: wrap;
                margin-top: 5rem;
                justify-content: center;
            }

            .menu .row .menu-card {
                text-align: center;
                padding-bottom: 4rem;
            }

            .menu .row .menu-card img {
                border-radius: 50%;
                width: 80%;
            }

            .menu .row .menu-card-title {
                margin-top: 1.5rem auto 0.5rem;
            }

            /* Kontak Section */
            .contact .row {
                display: flex;
                margin-top: 2rem;
                background-color: #222;
            }

            .contact .row .maps {
                flex: 1 1 45rem;
                width: 100%;
                object-fit: cover;
            }

            .contact .row form {
                flex: 1 1 45rem;
                padding: 5rem 2rem;
                text-align: center;
            }

            .contact .row form .input-group {
                display: flex;
                align-items: center;
                margin-top: 2rem;
                background-color: var(--bg);
                border: 1px solid #eee;
                padding-left: 2rem;
            }

            .contact .row form .input-group input {
                width: 100%;
                padding: 2rem;
                font-size: 1.7rem;
                background: none;
                color: #fff;
            }

            .contact .row form .btn {
                margin-top: 3rem;
                display: inline-block;
                padding: 1rem 3rem;
                font-size: 1.7rem;
                color: #fff;
                background-color: var(--primary);
                cursor: pointer;
            }

            /* Footer */
            footer {
                background-color: var(--primary);
                text-align: center;
                padding: 1rem 0 3rem;
                margin-top: 3rem;
            }

            footer .socials {
                padding: 1rem 0;
            }

            footer .socials a {
                color: #fff;
                margin: 1rem;
            }

            footer .socials a:hover,
            footer .links a:hover {
                color: var(--bg);
            }

            footer .links {
                margin-bottom: 1.4rem;
            }

            footer .links a {
                color: #fff;
                padding: 0.7rem 1rem;
            }

            footer .credit {
                font-size: 0.8rem;

            }

            footer .credit a {
                color: var(--bg);
                font-weight: 700;
            }

            /* media queries */

            /* Laptop */
            @media (max-width: 1366px) {
                html {
                    font-size: 75%;
                }
            }

            /* tablet */
            @media (max-width: 768px) {
                html {
                    font-size: 62.5%;
                }

                #hamburger-menu {
                    display: inline-block;
                }

                .navbar .navbar-nav {
                    position: absolute;
                    top: 100%;
                    right: -100%;
                    background-color: #fff;
                    width: 30rem;
                    height: 100vh;
                    transition: 0.3s;
                }

                .navbar .navbar-nav.active {
                    right: 0;
                }


                .navbar .navbar-nav a {
                    color: var(--bg);
                    display: block;
                    margin: 1.5rem;
                    padding: 0.5rem;
                    font-size: 2rem;
                }

                .navbar .navbar-nav a::after {
                    transform-origin: 0 0;
                }

                .navbar .navbar-nav a:hover::after {
                    transform: scaleX(0.2);
                }

                .about .row {
                    flex-wrap: wrap;
                }

                .about .row .about-img {
                    height: 24rem;
                    object-fit: cover;
                    object-position: center;
                }

                .about .row .content {
                    padding: 0;
                }

                .about .row .content h3 {
                    margin-top: 1rem;
                    font-size: 2rem;
                }

                .about .row .content p {
                    font-size: 1.6rem;
                }

                .menu p {
                    font-size: 1.2rem;
                }

                .contact .row {
                    flex-wrap: wrap;
                }

                .contact .row .maps {
                    height: 30rem;
                }

                .contact .row form {
                    padding-top: 0;
                }

            }

            /* mobile */
            @media (max-width: 450px) {
                html {
                    font-size: 55%;
                }
            }
        </style>
    </head>

<body>
    <!-- navbar start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">Kopi<span>Senja</span></a>
        <div class="navbar-nav">
            <a href="#">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#menu">Menu</a>
            <a href="#contact">Kontak</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="navbar-extra">
            <a href="#" id="search"><i data-feather="search"></i></a>
            <a href="#" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
        </div>
    </nav>
    <!-- navbar end -->

    <!-- Hero section start -->
    <section class="hero" id="home">
        <main class="content">
            <h1>Mari Nikmati Secangkir <span>Kopi</span></h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, incidunt?</p>
            <a href="#" class="cta">Beli Sekarang</a>
        </main>
    </section>


    <!-- About Section Start -->
    <section id="about" class="about">
        <h2><span>Tentang</span> Kami</h2>

        <div class="row">
            <div class="about-img">
                <img src="img/Tentang-Kami.jpg" alt="Tentang Kami">
            </div>
            <div class="content">
                <h3>Kenapa Memilih Kopi Kami?</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Accusamus facere architecto animi sint
                    minima
                    expedita!</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis voluptas nihil nam sint molestiae
                    aspernatur nobis odio! Quis, voluptatibus a.</p>
            </div>
        </div>
    </section>
    <!-- About Section end -->

    <!-- Menu Section start -->
    <section id="menu" class="menu">
        <h2><span>Menu</span> Kami</h2>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Neque, dignissimos. Vel corporis obcaecati ratione
            cumque.</p>

        <div class="row">
            <div class="menu-card">
                <img src="img/Menu/Coffe-Arabica.jpg" alt="Coffe-Arabica" class="menu-card-img">
                <h3 class="menu-card-title">- Coffe Arabica -</h3>
                <p class="menu-car-price">IDR 15K</p>
            </div>
            <div class="menu-card">
                <img src="img/Menu/Coffe-latte.jpg" alt="Coffe-Arabica" class="menu-card-img">
                <h3 class="menu-card-title">- Coffe Latte -</h3>
                <p class="menu-car-price">IDR 17K</p>
            </div>
            <div class="menu-card">
                <img src="img/Menu/Coffe-milk.jpg" alt="Coffe-Arabica" class="menu-card-img">
                <h3 class="menu-card-title">- Coffe Milk-</h3>
                <p class="menu-car-price">IDR 12K</p>
            </div>
            <div class="menu-card">
                <img src="img/Menu/Coffe-with-ice.jpg" alt="Coffe-Arabica" class="menu-card-img">
                <h3 class="menu-card-title">- Coffe With Ice-</h3>
                <p class="menu-car-price">IDR 10K</p>
            </div>
        </div>
    </section>
    <!-- Menu Section end -->

    <!-- Kontak Section start -->
    <section id="contact" class="contact">
        <h2><span>Kontak</span> Kami</h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, totam?</p>

        <div class="row">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127389.7609960423!2d102.22217617810736!3d-3.825170666032821!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e36b01e37e39279%3A0xa079b576e790a6ea!2sBengkulu%2C%20Kota%20Bengkulu%2C%20Bengkulu!5e0!3m2!1sid!2sid!4v1731937489743!5m2!1sid!2sid"
                allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="maps"></iframe>

            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <i data-feather="user"></i>
                    <input type="text" name="nama" placeholder="nama" required>
                </div>
                <div class="input-group">
                    <i data-feather="mail"></i>
                    <input type="email" name="email" placeholder="email" required>
                </div>
                <div class="input-group">
                    <i data-feather="phone"></i>
                    <input type="text" name="no_hp" placeholder="No HP" required>
                </div>
                <button type="submit" class="btn">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <!-- Kontak Section end -->

    <!-- Footer start -->
    <footer>
        <div class="socials">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>
        <div class="links">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#menu">Menu</a>
            <a href="#contact">Kontak</a>
        </div>

        <div class="credit">
            <p>Created by <a href="">Fun Project Team</a> | &copy; 2024</p>
        </div>
    </footer>
    <!-- Footer end -->

    <!-- feather -->
    <script>
        feather.replace();
    </script>

    <script>
        // Toggle class active
        const navbarNav = document.querySelector('.navbar-nav');
        // ketika hamburger menu diklik
        document.querySelector('#hamburger-menu').onclick = () => {
            navbarNav.classList.toggle('active')
        };

        // klik diluar sidebar ubtuk menghilangkan nav

        const hamburger = document.querySelector('#hamburger-menu');

        document.addEventListener('click', function (e) {
            if (!hamburger.contains(e.target) && !navbarNav.contains(e.target)) {
                navbarNav.classList.remove('active');
            }
        });
    </script>
</body>

</html>