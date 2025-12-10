<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Viorra.com - Hubungi Kami</title>
  <link rel="stylesheet" href="assets/css/style.css"/>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;
    }

    .card {
      background-color: white;
      padding: 30px 40px; /* Padding sedikit lebih besar untuk ruang napas */
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
      margin-top: 20px;
    }
    
    .judul-hubungi {
      text-align: center;
      color: #333;
      margin-top: 0;
      margin-bottom: 10px; /* Jarak ke sub-judul diperkecil */
    }

    /* === ATURAN BARU UNTUK MENGECILKAN FORM DI DALAM CARD === */
    #kontak-card form {
      max-width: 550px; /* <<< Lebar kolom form bisa diatur di sini */
      margin: 25px auto 0 auto; /* Memberi jarak dari judul dan membuatnya di tengah */
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input, textarea {
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    button {
      background-color: #25D366;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      font-weight: bold;
    }

    button:hover {
      background-color: #1ebe5d;
    }

    .main-footer {
      text-align: center;
      padding: 20px;
      font-size: 14px;
      color: #555;
      margin-top: 40px;
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
    <main class="card" id="kontak-card">
      <h1 class="judul-hubungi">Hubungi Kami</h1>
      <p style="text-align: center; color: #666;">
        Ada pertanyaan? Kirimkan pesan langsung ke WhatsApp kami.
      </p>
      
      <form onsubmit="return kirimKeWhatsapp();">
        <input type="text" id="nama" placeholder="Nama Anda" required />
        <input type="email" id="email" placeholder="Email Anda" required />
        <textarea id="pesan" placeholder="Tulis pesan Anda di sini..." required></textarea>
        <button type="submit">Kirim via WhatsApp</button>
      </form>
    </main>
  </div>
<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>

  <script>
    function kirimKeWhatsapp() {
      const nama = document.getElementById("nama").value;
      const email = document.getElementById("email").value;
      const pesan = document.getElementById("pesan").value;
      const nomorTujuan = "6281392024032";
      const teks = `Halo Viorra!%0A%0ASaya ${nama}%0AEmail: ${email}%0A%0APesan saya:%0A${pesan}`;
      const url = `https://wa.me/${nomorTujuan}?text=${teks}`;
      window.open(url, "_blank");
      return false;
    }
  </script>

</body>
</html>