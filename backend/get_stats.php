<?php
session_start();
include '../koneksi.php';

header('Content-Type: application/json');

$response = [
    'total_transaksi' => 0,       // Jumlah transaksi 'selesai'
    'total_user' => 0,            // Jumlah total user
    'total_products' => 0,        // Jumlah total produk
    'total_sales' => 0.00         // Total pendapatan dari transaksi 'selesai'
];

// Query untuk menghitung total transaksi 'selesai'
$query_transaksi = "SELECT COUNT(id_pesanan) AS total_transaksi, SUM(total_harga) AS total_sales FROM pesanan WHERE status_pesanan = 'selesai'";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);
if ($result_transaksi && mysqli_num_rows($result_transaksi) > 0) {
    $row_transaksi = mysqli_fetch_assoc($result_transaksi);
    $response['total_transaksi'] = $row_transaksi['total_transaksi'];
    $response['total_sales'] = $row_transaksi['total_sales'] ?? 0.00; // Pastikan default 0 jika null
}

// Query untuk menghitung total user
$query_user = "SELECT COUNT(id_user) AS total_user FROM users"; // Pastikan 'users' (dengan s)
$result_user = mysqli_query($koneksi, $query_user);
if ($result_user && mysqli_num_rows($result_user) > 0) {
    $row_user = mysqli_fetch_assoc($result_user);
    $response['total_user'] = $row_user['total_user'];
}

// Query untuk menghitung total produk
$query_products = "SELECT COUNT(id) AS total_products FROM produk";
$result_products = mysqli_query($koneksi, $query_products);
if ($result_products && mysqli_num_rows($result_products) > 0) {
    $row_products = mysqli_fetch_assoc($result_products);
    $response['total_products'] = $row_products['total_products'];
}

echo json_encode($response);
?>