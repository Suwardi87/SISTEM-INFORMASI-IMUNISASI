<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header('Location:../index.php?pesan=gagal'); // Redirect ke halaman login jika pengguna belum login
    exit(); // Pastikan untuk menghentikan eksekusi skrip setelah header redirect
}

// Cek apakah level pengguna sesuai dengan yang diizinkan untuk mengakses halaman ini
if (!isset($_SESSION['level']) || $_SESSION['level'] == "") {
    header('Location:../index.php?pesan=gagal'); // Redirect ke halaman login jika level pengguna tidak sesuai
    exit(); // Pastikan untuk menghentikan eksekusi skrip setelah header redirect
}