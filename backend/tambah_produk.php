<?php
session_start();
include '../koneksi.php'; // Sesuaikan path

// Proteksi Akses Admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    // Define the upload directory (relative to this script's location)
    $uploadDir = "uploads/"; 
    $targetFilePath = $uploadDir . basename($gambar); // Using basename for security

    // Move the uploaded file
    if (move_uploaded_file($tmp, $targetFilePath)) {
        // File uploaded successfully, now insert into database
        $stmt = mysqli_prepare($koneksi, "INSERT INTO produk (nama, harga, gambar) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sis", $nama, $harga, $gambar); // 's' for string, 'i' for integer

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Produk '" . htmlspecialchars($nama) . "' berhasil ditambahkan.";
            header("Location: produk.php"); // Redirect ke halaman produk setelah tambah
        } else {
            $_SESSION['error'] = "Gagal menambahkan produk ke database: " . mysqli_error($koneksi);
            // Hapus file yang sudah terupload jika insert database gagal
            if (file_exists($targetFilePath)) {
                unlink($targetFilePath);
            }
            header("Location: tambah_produk.php");
        }
        mysqli_stmt_close($stmt);
        exit();
    } else {
        $_SESSION['error'] = "Error saat mengunggah file. Pastikan folder 'uploads' ada dan memiliki izin tulis yang benar.";
        // Tambahkan logging lebih detail untuk debugging
        // error_log("Failed to move uploaded file: " . $tmp . " to " . $targetFilePath);
        header("Location: tambah_produk.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .sidebar { /* Menggunakan kelas .sidebar yang sudah ada */
            width: 250px; background-color: #343a40; color: white; padding: 20px; min-height: 100vh; position: fixed; top: 0; left: 0;
        }
        .sidebar .nav-link { color: rgba(255, 255, 255, 0.75); padding: 10px 15px; transition: background-color 0.3s ease, color 0.3s ease; }
        .sidebar .nav-link:hover { background-color: #495057; color: white; }
        .sidebar .nav-link.active { background-color: #dea193; color: white; border-radius: 5px; }
        .sidebar-info { margin-top: 30px; padding: 15px; background-color: #495057; border-radius: 5px; color: white; font-size: 0.9em; }
        .sidebar-info h4 { margin-top: 0; margin-bottom: 10px; color: #f0f0f0; }
        .sidebar-info p { margin-bottom: 5px; }
        .sidebar-info span { font-weight: bold; color: #ffcc00; }
        .content { margin-left: 250px; padding: 20px; flex-grow: 1; }
        .message-box { padding: 10px; margin-bottom: 15px; border-radius: 5px; }
        .message-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
<div class="d-flex">
    <div class="sidebar">
        <h4 class="text-center mb-4">Viorra</h4>
        <nav class="nav flex-column">
            <a href="dashboard.php" class="nav-link text-white">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="produk.php" class="nav-link text-white active">
                <i class="bi bi-box-seam me-2"></i> Produk
            </a>
            <a href="pengguna.php" class="nav-link text-white">
                <i class="bi bi-people me-2"></i> Pengguna
            </a>
            <a href="Transaksi.php" class="nav-link text-white">
                <i class="bi bi-plus-circle me-2"></i> Transaksi
            </a>
            <a href="../logout.php" class="nav-link text-white">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </a>
        </nav>

        <div class="sidebar-info">
            <h4>Informasi Statistik</h4>
            <p>Produk Terjual: <span id="produk-terjual-count">Loading...</span></p>
            <p>User Terdaftar: <span id="user-terdaftar-count">Loading...</span></p>
        </div>
    </div>

    <div class="content">
        <h2 class="mb-4">Tambah Produk Baru</h2>

        <?php 
        if (isset($_SESSION['success'])): ?>
            <div class="message-box message-success">
                <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php elseif (isset($_SESSION['error'])): ?>
            <div class="message-box message-error">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Produk</label>
                <input type="text" name="nama" id="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" name="harga" id="harga" class="form-control" required min="0">
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control" required accept="image/*">
            </div>
            <button class="btn btn-primary" type="submit"><i class="bi bi-save me-2"></i>Simpan Produk</button>
            <a href="produk.php" class="btn btn-secondary"><i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Produk</a>
        </form>
    </div>
</div>

<script>
// Script untuk memuat statistik menggunakan AJAX
$(document).ready(function() {
    function loadStats() {
        $.ajax({
            url: 'get_stats.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#produk-terjual-count').text(data.total_transaksi);
                $('#user-terdaftar-count').text(data.total_user);
            },
            error: function(xhr, status, error) {
                console.error("Error loading stats:", status, error);
                $('#produk-terjual-count').text("N/A");
                $('#user-terdaftar-count').text("N/A");
            }
        });
    }
    loadStats();
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>