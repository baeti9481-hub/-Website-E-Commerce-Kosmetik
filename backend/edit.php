<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE id=$id"));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];

  if ($_FILES['gambar']['name']) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    move_uploaded_file($tmp, "uploads" . $gambar);
    mysqli_query($koneksi, "UPDATE produk SET nama='$nama', harga='$harga', gambar='$gambar' WHERE id=$id");
  } else {
    mysqli_query($koneksi, "UPDATE produk SET nama='$nama', harga='$harga'WHERE id=$id");
  }
  header("Location: produk.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3>Edit Produk</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama Produk</label>
      <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Harga</label>
      <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Ganti Gambar</label>
      <input type="file" name="gambar" class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Update</button>
    <a href="produk.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>
