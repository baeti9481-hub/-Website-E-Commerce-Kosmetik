<?php
$koneksi = mysqli_connect("localhost", "root", "", "viorra_db");
if (!$koneksi) {
  die("Koneksi gagal: " . mysqli_connect_error());
}
?>
