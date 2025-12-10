<!DOCTYPE html>
<html lang="id">

<head>
   
  <meta charset="UTF-8" />
   
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Viorra.com - Hubungi Kami</title>
   
  <link rel="stylesheet" href="assets/css/style.css" />
    <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    main {
      padding: 40px 20px;
      max-width: 600px;
      margin: auto;
    }

    .judul-hubungi {
      text-align: center;
      color: black;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 20px;
    }

    input,
    textarea {
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
    }

    button:hover {
      background-color: #1ebe5d;
    }

    footer {
      background-color: #f4f4f4;
      text-align: center;
      padding: 20px;
      font-size: 14px;
      color: #555;
      margin-top: 40px;
    }
  </style>
</head>

<body>

  <header class="navbar" style="padding: 10px; border-bottom: 2px solid #DEA193; background-color: white;">
      <div class="container" style="display: flex; flex-direction: column; align-items: center;">
          <img src="assets/images/Logo Viorra.png" alt="Logo Viorra" style="width: 80px;">
          <h1 style="color: #DEA193; margin: 10px 0;">Viorra.com</h1>
         
          <nav style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center; margin-bottom: 10px;">
              <a href="index.php" style="color: #DEA193; text-decoration: none; font-weight: bold;">Home</a>
              <a href="produk.php" style="color: #DEA193; text-decoration: none; font-weight: bold;">Produk</a>
              <a href="keranjang.php" style="color: #DEA193; text-decoration: none; font-weight: bold;">Keranjang</a>
              <a href="login.php" style="color: #DEA193; text-decoration: none; font-weight: bold;">Login</a>
              <a href="about.php" style="color: #DEA193; text-decoration: none; font-weight: bold;">Tentang Kami</a>
              <a href="kontak.php" style="color: #DEA193; text-decoration: none; font-weight: bold;">Kontak Kami</a>
            </nav>
        </div>
  </header>

  <main>
      <h1 class="judul-hubungi" style="color: #DEA193;">Hubungi Kami</h1>
      <form onsubmit="return kirimKeWhatsapp();">
          <input type="text" id="nama" placeholder="Nama Anda" required />
          <input type="email" id="email" placeholder="Email Anda" required />
          <textarea id="pesan" placeholder="Tulis pesan Anda di sini..." required></textarea>
          <button type="submit">Kirim via WhatsApp</button>
        </form>
  </main>

<footer class="container" style="text-align:center; padding:10px; background: #dea193; color:white; margin-top:20px;">
    <p>&copy; 2025 Viorra.com | All Rights Reserved</p>
</footer>

  <script>
    function kirimKeWhatsapp() {
      const nama = document.getElementById("nama").value;
      const email = document.getElementById("email").value;
      const pesan = document.getElementById("pesan").value;

      const nomorTujuan = "6281392024032"; // Tanpa +

      // PERBAIKAN: Menggunakan backtick (`) untuk membuat string dan menghapus titik koma (;) yang salah
      const teks = `Halo Viorra!%0ASaya ${nama} (${email}) ingin bertanya:%0A${pesan}`;
      const url = `https://wa.me/${nomorTujuan}?text=${teks}`;

      window.open(url, "_blank");
      return false;
    }
  </script>

</body>

</html>