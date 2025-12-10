<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - Viorra.com</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Navbar -->
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
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="login-button">Login</a>
                <?php endif; ?>
            </div>
            
        </nav>
    </header>
</div>
<!-- Keunggulan -->
<section class="container">
    <div class="advantages">
        <div class="advantage-item">
            <h3><i class="fas fa-money-bill-wave"></i> Harga Terjangkau</h3>
            <p>Kami menawarkan harga terbaik dengan berbagai promo menarik setiap bulannya.</p>
        </div>
        <div class="advantage-item">
            <h3><i class="fas fa-truck-fast"></i> Pengiriman Cepat</h3>
            <p>Pesanan Anda akan dikirim dengan cepat dan aman ke seluruh Indonesia.</p>
        </div>
        <div class="advantage-item">
            <h3><i class="fas fa-lock"></i> Transaksi Aman</h3>
            <p>Keamanan data pelanggan adalah prioritas kami dengan metode pembayaran terpercaya.</p>
        </div>
    </div>
</section>

<section class="container">
        <div class="advantages">
    <div style="text-align: center;"> 
        <h2>Hubungi Kami</h2>
    </div>
    
        <p class="contact-description">Jika Anda memiliki pertanyaan atau membutuhkan bantuan, silakan hubungi kami melalui:</p>
    
        <div class="contact-box">
        
                <p><i class="fas fa-map-marker-alt"></i> Alamat: Jl. Kh Imam Johar Kota Tegal</p>
        <p><i class="fas fa-phone"></i> Telepon: <a href="tel:+62812345678910">+62 8123-4567-8810</a></p>
        <p><i class="fas fa-envelope"></i> Email: <a href="mailto:support@Viorra.com">support@Viorra.com</a></p>
        <p><i class="fas fa-globe"></i> Website: <a href="https://www.Viorra.com" target="_blank">www.Viorra.com</a></p>
    </div>
</section>

<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>
</body>
</html>