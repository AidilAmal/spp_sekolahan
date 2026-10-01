<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

$id_kelas = $_GET['id_kelas'];

mysqli_query($koneksi, "DELETE FROM tb_kelas WHERE id_kelas='$id_kelas'");

header("location:index.php");

?>
