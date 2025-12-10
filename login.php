<?php
session_start();
$success_message = '';
if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']); // supaya tidak muncul terus
}

$error_message = ''; // Tambahkan variabel untuk pesan error
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); // Hapus pesan error setelah ditampilkan
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Viorra.com</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Tambahan style untuk pesan error/sukses */
        .message-box {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .message-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <header class="navbar" style="box-shadow: 0 0 10px #dea193;">
        <img src="assets/images/Logo Viorra.png" alt="Logo Viorra" class="logo">
        <nav>
            <a href="index.php">Home</a>
            <a href="produk.php">Produk</a>
            <a href="keranjang.php">Keranjang</a>
            <a href="about.php">Tentang Kami</a>
            <a href="kontak.php">Kontak Kami</a>
            
            <div class="user-info">
                <?php if (isset($_SESSION['user_id'])): ?>
                  <span class="user-greeting">Halo, <?= htmlspecialchars($_SESSION['username'] ?? '') ?>!</span>
                    <?php if (isset($_SESSION['level']) && $_SESSION['level'] === 'admin'): ?>
                        <a href="backend/dashboard.php" class="login-button" style="margin-left: 10px;">Admin Panel</a>
                    <?php endif; ?>
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="login-button">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</div>

    <section class="auth-container" style="box-shadow: 0 4px 8px #DEA193;">
        <h2>Login ke Akun Anda</h2>

        <?php if ($success_message): ?>
            <div class="message-box message-success">
                <?= htmlspecialchars($success_message) ?>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="message-box message-error">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </section>

    <footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>

</body>
</html>