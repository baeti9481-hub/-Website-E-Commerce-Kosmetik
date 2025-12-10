<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Viorra.com</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Navbar -->
<div class="container" style="    box-shadow: 0 4px 8px #DEA193;">
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
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="login-button">Login</a>
                <?php endif; ?>
            </div>
            
        </nav>
    </header>
</div>

    <!-- Form Register -->
    <section class="auth-container">
        <h2>Daftar Akun Baru</h2>
        <form action="proses_register.php" method="POST">
            <label for="name">Nama Lengkap:</label>
            <input type="text" id="name" name="name" placeholder="Masukkan nama Anda" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Masukkan email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>

            <label for="confirm_password">Konfirmasi Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Ulangi password" required>

            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </section>

    <!-- Footer -->
<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>

</body>
</html>
