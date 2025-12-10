<?php
include 'koneksi.php';
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM produk WHERE id=$id");
header("Location: dashboard.php");
?>
