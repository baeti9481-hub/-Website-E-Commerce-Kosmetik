<?php
// Pastikan file koneksi.php ada di direktori yang benar (misalnya, di luar folder backend jika diletakkan di root)
include '../koneksi.php'; // Sesuaikan path ini jika koneksi.php berada di lokasi lain

// Query untuk mengambil semua data transaksi
// Asumsi: Ada tabel 'transaksi'
$query = "SELECT * FROM transaksi ORDER BY tanggal_transaksi DESC";
$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna - Admin Viorra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f8f9fa; /* Warna latar belakang */
        }
        .admin-container { 
            display: flex; /* Untuk layout sidebar dan konten */
        }
        /* Style untuk sidebar */
        .sidebar { 
            width: 250px;
            background-color: #343a40; /* Warna gelap */
            color: white;
            padding: 20px;
            min-height: 100vh; /* Set tinggi minimum sidebar */
            position: fixed; /* Agar sidebar tetap di posisi saat scroll */
            top: 0;
            left: 0;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75); /* Warna teks link */
            padding: 10px 15px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: #495057; /* Warna hover */
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #dea193; /* Warna aktif, sesuai tema Viorra */
            color: white;
            border-radius: 5px; /* Sedikit lengkungan */
        }
        /* Style untuk bagian info statistik di sidebar */
        .sidebar-info { 
            margin-top: 30px;
            padding: 15px;
            background-color: #495057; /* Warna latar belakang info */
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
            color: #ffcc00; /* Warna highlight untuk angka */
        }
        /* Style untuk konten utama */
        .admin-content { 
            flex-grow: 1; /* Konten akan mengisi sisa ruang */
            padding: 20px; 
            margin-left: 250px; /* Dorong konten agar tidak tertutup sidebar */
        }
        .table-container { 
            margin-top: 20px; /* Spasi di atas tabel */
        }
    </style>
</head>
<body>
<div class="admin-container">
    <div class="sidebar">
        <h4 class="text-center mb-4">Viorra</h4>
        <nav class="nav flex-column">
            <a href="dashboard.php" class="nav-link text-white">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            <a href="produk.php" class="nav-link text-white">
                <i class="bi bi-box-seam me-2"></i> Produk
            </a>
            <a href="pengguna.php" class="nav-link text-white">
                <i class="bi bi-people me-2"></i> Pengguna
            </a>
            <a href="Transaksi.php" class="nav-link text-white active">
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
        <div class="admin-content">
    <div class="container-fluid">
            <h2 class="mb-4">Daftar Transaksi</h2>
               <table class="table table-bordered table-striped">
                <thead class="table-danger">
                    <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Format mata uang Rupiah
                        $total_formatted = "Rp " . number_format($row['total_harga'], 0, ',', '.');
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_pelanggan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_transaksi']) . "</td>";
                        echo "<td>" . $total_formatted . "</td>";
                        echo "<td>" . htmlspecialchars($row['status_transaksi']) . "</td>";
                        echo "<td>
                                <a href='detail_transaksi.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Detail</a>
                                <a href='proses_transaksi.php?action=hapus&id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus transaksi ini?');\">Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data transaksi ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>