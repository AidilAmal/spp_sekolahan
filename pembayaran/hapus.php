<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin();

include_once __DIR__ . "/../config/koneksi.php";

$id_pembayaran = $_GET['id_pembayaran'];

mysqli_query($koneksi, "DELETE FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran'");

header("location:index.php");

?>
