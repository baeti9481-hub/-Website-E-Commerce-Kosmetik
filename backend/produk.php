<?php
session_start();
include '../koneksi.php'; // Sesuaikan path

// Proteksi Akses Admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$result = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            padding: 20px;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 10px 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #dea193;
            color: white;
            border-radius: 5px;
        }
        .sidebar-info {
            margin-top: 30px;
            padding: 15px;
            background-color: #495057;
            border-radius: 5px;
            color: white;
            font-size: 0.9em;
        }
        .sidebar-info h4 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #f0f0f0;
        }
        .sidebar-info p {
            margin-bottom: 5px;
        }
        .sidebar-info span {
            font-weight: bold;
            color: #ffcc00;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .table img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }
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

 <!-- Konten Utama -->
        <div class="content">
            <h2 class="mb-4">Daftar Produk</h2>
            <a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk Baru</a>
               <table class="table table-bordered table-striped">
                <thead class="table-danger">
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td><img src="uploads/<?= htmlspecialchars($row['gambar']) ?>" width="100" alt="<?= htmlspecialchars($row['nama']) ?>"></td>
                            <td>
                                <a href="detail.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-info btn-sm text-white">Detail</a>
                                <a href="edit.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (mysqli_num_rows($result) == 0): ?>
                        <tr>
                            <td colspan="5" class="text-center">Belum ada produk.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
                    // Tidak ada card ringkasan di sini, jadi tidak perlu update yang itu
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