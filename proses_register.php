<?php
session_start();
include 'koneksi.php';

$nama_dari_form = $_POST['name'];
$email_dari_form = $_POST['email'];
$password_dari_form = $_POST['password'];
$confirm_password_dari_form = $_POST['confirm_password'];

if (empty($nama_dari_form) || empty($email_dari_form) || empty($password_dari_form)) {
    echo "<script>alert('Semua kolom wajib diisi!'); window.location='register.php';</script>";
    exit();
}
if ($password_dari_form !== $confirm_password_dari_form) {
    echo "<script>alert('Password dan Konfirmasi Password tidak cocok!'); window.location='register.php';</script>";
    exit();
}

$hashed_password = password_hash($password_dari_form, PASSWORD_DEFAULT);

// Perhatikan nama kolom: `username`, `email`, `password`
$query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($koneksi, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sss", $nama_dari_form, $email_dari_form, $hashed_password);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
        header('Location: login.php');
        exit();
    } else {
        echo "<script>alert('Registrasi gagal! Email mungkin sudah terdaftar.'); window.location='register.php';</script>";
    }
}
?>