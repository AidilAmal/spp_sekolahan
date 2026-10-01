<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

$id_petugas = $_GET['id_petugas'];

mysqli_query($koneksi, "DELETE FROM tb_petugas WHERE id_petugas='$id_petugas'");

header("location:index.php");

?>
