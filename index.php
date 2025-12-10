<?php
session_start(); // WAJIB: Mulai session di baris paling atas

// 1. Sertakan file koneksi database
include 'koneksi.php';

// 2. Buat query untuk mengambil produk terbaru (misal 3 produk terakhir)
// Pastikan tabel produk Anda memiliki kolom 'id' sebagai primary key yang auto-increment
$query_produk = "SELECT * FROM produk ORDER BY id DESC LIMIT 3";
$result_produk = mysqli_query($koneksi, $query_produk);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - Viorra.com</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<div class="container">
    <header class="navbar">
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

    <section class="hero-carousel">
        <div class="carousel-slide">
            <img src="assets/images/banner1.jpg" alt="Promo Voucher"> 
        </div>
        <div class="carousel-slide">
            <img src="assets/images/banner2.jpg" alt="Produk Baru">
        </div>
        <div class="carousel-slide">
            <img src="assets/images/banner3.jpg" alt="Info Lainnya">
        </div>
        
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </section>

    <section class="produk-terbaru">
        <h2>Produk Terbaru</h2>
        <div class="produk-grid">
            <?php if ($result_produk && mysqli_num_rows($result_produk) > 0) : ?>
                <?php while ($item = mysqli_fetch_assoc($result_produk)) : ?>
                <div class="produk-item">
                    <img src="backend/uploads/<?= htmlspecialchars($item['gambar']); ?>" alt="<?= htmlspecialchars($item['nama']); ?>">
                    <h3><?= htmlspecialchars($item['nama']); ?></h3>
                    <p>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></p>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Saat ini belum ada produk terbaru.</p>
            <?php endif; ?>
        </div>
    </section>
<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>   
</div> <script>
    let slideIndex = 1;
    let slideInterval;

    function showCurrentSlide(n) {
        let i;
        let slides = document.getElementsByClassName("carousel-slide");
        if (slides.length === 0) return; // Mencegah error jika tidak ada slide
        if (n > slides.length) { slideIndex = 1 }
        if (n < 1) { slideIndex = slides.length }

        for (i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }

        slides[slideIndex - 1].classList.add("active");
    }

    function plusSlides(n) {
        clearInterval(slideInterval); 
        showCurrentSlide(slideIndex += n);
        startSlideShow(); 
    }
    
    function startSlideShow() {
        slideInterval = setInterval(function() {
            plusSlides(1);
        }, 5000); 
    }

    document.addEventListener("DOMContentLoaded", function() {
        showCurrentSlide(slideIndex);
        startSlideShow();
    });
</script>

</body>
</html>