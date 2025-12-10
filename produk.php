<?php
session_start(); // WAJIB DI BARIS PALING ATAS
include 'koneksi.php';

$cari = isset($_GET['cari']) ? strtolower($_GET['cari']) : '';
// Peningkatan keamanan dengan prepared statements
if ($cari !== '') {
    $search_term = "%" . $koneksi->real_escape_string($cari) . "%";
    $stmt = $koneksi->prepare("SELECT * FROM produk WHERE LOWER(username) LIKE ?");
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM produk";
    $result = mysqli_query($koneksi, $query);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viorra.com - Produk</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* === STYLE UNTUK FORM PENCARIAN - UKURAN DIRAPIKAN === */
        .navbar-search {
            text-align: center; 
            margin-top: 15px;   
            padding-top: 15px;  
            border-top: 1px solid #EAD7D3; 
        }

        /* Kunci untuk membuat input dan tombol sejajar */
        .navbar-search form {
            display: flex;
            justify-content: center;
            align-items: center; 
        }

        /* Padding dan font disamakan agar tinggi identik */
        .navbar-search input[type="text"] {
            padding: 8px 12px; 
            border: 1px solid #ccc;
            width: 220px;
            font-size: 14px; 
            border-radius: 5px 0 0 5px; /* Sudut kiri melengkung */
            margin-right: -1px; /* Trik agar border menyatu */
        }
        .navbar-search button {
            padding: 8px 12px; 
            background-color: #DEA193;
            color: white;
            border: 1px solid #DEA193;
            cursor: pointer;
            font-size: 14px;
            border-radius: 0 5px 5px 0; /* Sudut kanan melengkung */
        }
        /* ======================================= */

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }
        .product {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            width: 220px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
        }
        .product h3 {
            font-size: 16px;
            margin: 10px 0;
            flex-grow: 1;
        }
        .price {
            color: #DEA193;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .product button {
            background-color: #DEA193;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: auto;
        }
        .product button:hover {
            background-color: #c98c7b;
        }
    </style>
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
        
        <div class="navbar-search">
            <form action="produk.php" method="GET">
                <input type="text" name="cari" placeholder="Cari produk..." value="<?= htmlspecialchars($cari) ?>"
                ><button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>

    </header>
</div>



<section class="container" style="    box-shadow: 0 4px 8px #DEA193;">
    <div class="product-container">
        <h2 style="text-align:center; margin: 20px 0; width: 100%; color:#DEA193">Daftar Produk</h2>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                
                $onclick_action = '';
                if (isset($_SESSION['user_id'])) { 
$onclick_action = "onclick=\"tambahKeKeranjang('{$row['nama']}', {$row['harga']}, 'backend/uploads/{$row['gambar']}')\"";
                } else {
                    $onclick_action = "onclick=\"alert('Anda harus login untuk menambahkan produk ke keranjang!'); window.location.href='login.php';\"";
                }

                echo "
                <div class='product'>
                    <div>
                        <img src='backend/uploads/{$row['gambar']}' alt='{$row['nama']}'>
                        <h3>{$row['nama']}</h3>
                        <p class='price'>Rp " . number_format($row['harga'], 0, ',', '.') . "</p>
                    </div>
                    <button {$onclick_action}>Tambah Ke Keranjang</button>
                </div>";
            }
        } else {
            echo "<p style='text-align:center; width: 100%;'>Tidak ada produk dengan kata kunci <strong>'" . htmlspecialchars($cari) . "'</strong>.</p>";
        }
        ?>
    </div>
</section>

<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>
<script>
  function tambahKeKeranjang(nama, harga, gambar) {
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
    const index = keranjang.findIndex(item => item.nama === nama);
    if (index !== -1) {
      keranjang[index].jumlah += 1;
    } else {
      keranjang.push({ nama, harga, gambar, jumlah: 1 });
    }
    localStorage.setItem('keranjang', JSON.stringify(keranjang));
    alert(`"${nama}" telah ditambahkan ke keranjang!`);
  }
</script>

</body>
</html>