<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();
include_once __DIR__ . "/../config/koneksi.php";

$nisn = mysqli_real_escape_string($koneksi, $_GET['nisn']);

$p1 = mysqli_query($koneksi, "SELECT 1 FROM tb_pembayaran WHERE nisn='$nisn' LIMIT 1");
$p2 = mysqli_query($koneksi, "SELECT 1 FROM tb_cek_pembayaran WHERE nisn='$nisn' LIMIT 1");

if (mysqli_num_rows($p1) > 0 || mysqli_num_rows($p2) > 0) {
    echo "<script>alert('Siswa tidak bisa dihapus karena sudah punya data pembayaran.');
          window.location='index.php';</script>";
    exit;
}

mysqli_query($koneksi, "DELETE FROM tb_siswa WHERE nisn='$nisn'");
header("location:index.php");