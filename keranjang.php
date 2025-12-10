<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Keranjang Belanja - Viorra.com</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <style>
    /* Asumsi .container dari style.css mengatur max-width & margin: auto */
    /* Jika tidak, Anda bisa menambahkan ini:
    .container {
      max-width: 1200px; 
      margin: 0 auto;
      padding: 0 15px;
    }
    */

    /* === GAYA UTAMA UNTUK CARD === */
    .card {
      background-color: white;
      padding: 20px 25px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      margin-top: 20px;
    }
    /* === GAYA UNTUK KONTEN KERANJANG === */
    #konten-keranjang {
      display: grid;
      gap: 15px;
    }

    .keranjang-item {
      display: flex;
      align-items: center;
      border-bottom: 1px solid #ddd;
      padding-bottom: 15px;
      gap: 15px;
    }
    .keranjang-item:last-of-type {
      border-bottom: none; /* Hilangkan border di item terakhir */
    }
    .keranjang-item img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
    }
    .keranjang-item .info {
      flex: 1;
    }
    .keranjang-item .info p {
      margin: 5px 0;
    }
    .btn-group {
      display: flex;
      flex-direction: column;
      gap: 5px;
    }
    .hapus-btn, .qty-btn {
      background-color: #c0392b;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }
    .qty-btn {
      background-color: #3498db;
    }
    .checkout-btn {
      background-color: #27ae60;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
      justify-self: start; /* Tombol checkout tidak melebar penuh */
    }
    .checkout-btn:hover {
      background-color: #219150;
    }
    .kosong {
      font-style: italic;
      color: #888;
      text-align: center;
      padding: 20px 0;
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
                    <a href="logout.php" class="logout-button">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="login-button">Login</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
</div>


<div class="container" style="    box-shadow: 0 4px 8px #DEA193;">
  <section class="card" id="konten-keranjang">
    <h2>Keranjang Belanja Anda</h2>
    <div id="keranjang-list"></div>
    <p id="total-harga" style="font-weight: bold; text-align: right; font-size: 1.1em;"></p>
    <button class="checkout-btn" onclick="checkout()">Checkout</button>
  </section>
</div>

<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>

<script>
  function tampilkanKeranjang() {
    // Data contoh untuk pengujian (bisa dihapus jika data sudah dari halaman produk)
    /*
    if (!localStorage.getItem('keranjang')) {
      const contohData = [
        { nama: 'Bedak Padat Viorra', harga: 500000, jumlah: 1, gambar: 'https://via.placeholder.com/80' },
        { nama: 'Foundation Viorra', harga: 300000, jumlah: 1, gambar: 'https://via.placeholder.com/80' }
      ];
      localStorage.setItem('keranjang', JSON.stringify(contohData));
    }
    */

    const keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
    const container = document.getElementById('keranjang-list');
    const totalHargaElem = document.getElementById('total-harga');
    const checkoutBtn = document.querySelector('.checkout-btn');
    const keranjangSection = document.getElementById('konten-keranjang');

    if (keranjang.length === 0) {
      keranjangSection.innerHTML = "<h2>Keranjang Belanja Anda</h2><p class='kosong'>Keranjang masih kosong.</p>";
      return;
    }
    
    // Tampilkan kembali elemen jika sebelumnya kosong
    checkoutBtn.style.display = "inline-block";
    totalHargaElem.style.display = "block";

    let total = 0;
    let html = "";
    keranjang.forEach((item, index) => {
      const subtotal = item.harga * item.jumlah;
      total += subtotal;
      html += `
        <div class="keranjang-item">
          <img src="${item.gambar}" alt="${item.nama}" />
          <div class="info">
            <p><strong>${item.nama}</strong></p>
            <p>Rp ${item.harga.toLocaleString('id-ID')} x ${item.jumlah} = <strong>Rp ${subtotal.toLocaleString('id-ID')}</strong></p>
          </div>
          <div class="btn-group">
            <button class="qty-btn" onclick="ubahJumlah(${index}, 1)">+</button>
            <button class="qty-btn" onclick="ubahJumlah(${index}, -1)">−</button>
            <button class="hapus-btn" onclick="hapusItem(${index})">Hapus</button>
          </div>
        </div>
      `;
    });
    container.innerHTML = html;
    totalHargaElem.textContent = "Total Harga: Rp " + total.toLocaleString('id-ID');
  }

  function hapusItem(index) {
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
    keranjang.splice(index, 1);
    localStorage.setItem('keranjang', JSON.stringify(keranjang));
    tampilkanKeranjang();
  }

  function ubahJumlah(index, delta) {
    let keranjang = JSON.parse(localStorage.getItem('keranjang')) || [];
    if (keranjang[index]) {
      keranjang[index].jumlah += delta;
      if (keranjang[index].jumlah < 1) {
        // Panggil fungsi hapus jika jumlah jadi 0
        hapusItem(index);
        return; 
      }
      localStorage.setItem('keranjang', JSON.stringify(keranjang));
      tampilkanKeranjang();
    }
  }

  function checkout() {
    alert("Terima kasih telah berbelanja di Viorra.com! Pesanan Anda akan segera diproses.");
    localStorage.removeItem('keranjang');
    tampilkanKeranjang();
  }

  document.addEventListener("DOMContentLoaded", tampilkanKeranjang);
</script>

</body>
</html>