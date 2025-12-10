<?php
session_start(); // WAJIB DI BARIS PALING ATAS
include 'koneksi.php'; // Pastikan path ini benar ke koneksi.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Gunakan Prepared Statement untuk mencegah SQL Injection
    // Ambil id_user, nama, password (hash), dan level dari database
    $stmt = mysqli_prepare($koneksi, "SELECT id_user, username, email, password, level FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email); // 's' menandakan tipe data string untuk email
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // 2. Verifikasi password yang di-hash
        // Gunakan password_verify() untuk membandingkan password yang diinput dengan hash di database
        if (password_verify($password, $user['password'])) {
            // Login Berhasil
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level']; // SIMPAN LEVEL PENGGUNA DI SESSION

            // Set pesan sukses (opsional, jika Anda ingin ada pesan setelah login)
            // $_SESSION['success'] = "Selamat datang, " . htmlspecialchars($user['nama']) . "!";

            // 3. Redirect berdasarkan level pengguna
            if ($user['level'] === 'admin') {
                header("Location: backend/dashboard.php"); // Redirect ke dashboard admin
            } else {
                header("Location: index.php"); // Redirect ke halaman utama untuk user biasa
            }
            exit(); // Penting: Hentikan eksekusi script setelah redirect
        } else {
            // Password salah
            $_SESSION['error'] = "Email atau password salah.";
            header("Location: login.php"); // Kembali ke halaman login dengan pesan error
            exit();
        }
    } else {
        // Email tidak ditemukan
        $_SESSION['error'] = "Email atau password salah.";
        header("Location: login.php"); // Kembali ke halaman login dengan pesan error
        exit();
    }
    mysqli_stmt_close($stmt); // Tutup statement
} else {
    // Jika akses langsung ke proses_login.php tanpa POST request
    header("Location: login.php");
    exit();
}
?>