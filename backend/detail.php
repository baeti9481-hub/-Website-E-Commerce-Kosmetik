<?php
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validasi parameter id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}

$id = (int)$_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");

if (!$query || mysqli_num_rows($query) == 0) {
    die("Produk tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Detail Produk</h3>

    <div class="card mb-3" style="max-width: 600px;">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" class="img-fluid rounded-start" alt="Gambar Produk">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($data['nama']) ?></h5>
                    <p class="card-text"><strong>Harga:</strong> Rp <?= number_format($data['harga'], 0, ',', '.') ?></p>
                    <p class="card-text"><small class="text-muted">ID Produk: <?= $data['id'] ?></small></p>
                </div>
            </div>
        </div>
    </div>

    <a href="produk.php" class="btn btn-secondary">Kembali ke Produk</a>
</div>
</body>
</html>
