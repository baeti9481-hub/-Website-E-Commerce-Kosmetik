<?php
session_start();
include '../koneksi.php';

// Proteksi Akses Admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['level']) || $_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

// Tidak perlu query produk lagi di sini, karena ini akan jadi dashboard ringkasan
// Anda bisa menambahkan query untuk statistik ringkasan lain jika mau
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Viorra</title>
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
        /* Hapus style table img jika tidak ada tabel produk di sini */
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar">
            <h4 class="text-center mb-4">Viorra</h4>
            <nav class="nav flex-column">
                <a href="dashboard.php" class="nav-link text-white active">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="produk.php" class="nav-link text-white">
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
            <h2 class="mb-4">Dashboard Admin</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card text-center bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-boxes me-2"></i> Jumlah Produk</h5>
                            <p class="card-text fs-3"><span id="jumlah-produk-count">0</span></p>
                            <a href="produk.php" class="btn btn-outline-light btn-sm">Kelola Produk</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center bg-info text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-person-fill me-2"></i> Total Pengguna</h5>
                            <p class="card-text fs-3"><span id="total-pengguna-count">0</span></p>
                            <a href="pengguna.php" class="btn btn-outline-light btn-sm">Kelola Pengguna</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card text-center bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-plus-circle me-2"></i> Total Transaksi</h5>
                            <p class="card-text fs-3"><span id="total-pengguna-count">0</span></p>
                            <a href="pengguna.php" class="btn btn-outline-light btn-sm">Kelola Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>
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
                    
                    // Untuk card ringkasan di dashboard
                    $('#total-penjualan-amount').text(new Intl.NumberFormat('id-ID').format(data.total_sales));
                    $('#jumlah-produk-count').text(data.total_products);
                    $('#total-pengguna-count').text(data.total_user);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading stats:", status, error);
                    $('#produk-terjual-count').text("N/A");
                    $('#user-terdaftar-count').text("N/A");
                    $('#total-penjualan-amount').text("N/A");
                    $('#jumlah-produk-count').text("N/A");
                    $('#total-pengguna-count').text("N/A");
                }
            });
        }

        loadStats();
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>