<?php

/**
 * auth.php - Helper cek session & level akses
 */

// Cek apakah sudah login, kalau belum redirect ke login
function cekLogin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        header("location:/spp_sekolah/login.php");
        exit;
    }
}

// Cek apakah level admin, kalau bukan tampilkan pesan akses ditolak
function cekAdmin() {
    cekLogin();
    if ($_SESSION['level'] !== 'admin') {
        die("
        <div style='font-family:Arial; text-align:center; margin-top:100px;'>
            <h2 style='color:red;'>⛔ Akses Ditolak</h2>
            <p>Halaman ini hanya bisa diakses oleh <strong>Admin</strong>.</p>
            <a href='/spp_sekolah/dashboard.php' 
               style='padding:10px 20px; background:#333; color:white; 
                      text-decoration:none; border-radius:5px;'>
               Kembali ke Dashboard
            </a>
        </div>
        ");
    }
}
