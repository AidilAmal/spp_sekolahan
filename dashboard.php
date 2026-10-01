<?php
include_once __DIR__ . '/config/auth.php';
cekLogin();
include 'config/koneksi.php';

// Hitung siswa sudah lunas
$lunas = mysqli_num_rows(
    mysqli_query($koneksi,
    "SELECT * FROM tb_pembayaran
    WHERE status='Sudah Lunas'")
);

// Hitung siswa belum lunas
$belum = mysqli_num_rows(
    mysqli_query($koneksi,
    "SELECT * FROM tb_pembayaran
    WHERE status='Belum Lunas'")
);

?>

<?php include "template/header.php"; ?>

<?php include "template/sidebar.php"; ?>


<div class="content">

<!-- Sapaan -->
<h5 class="mb-4">
    Selamat Datang, <?= $_SESSION['nama'] ?? 'Administrator' ?>
</h5>


<!-- 2 Kartu: Sudah Lunas & Belum Lunas (sesuai foto) -->
<div class="row mb-4 justify-content-center">

    <div class="col-md-4">
    <div class="card border-0 shadow-sm">
    <div class="card-body text-center p-4">
        <p class="mb-1 text-muted">Siswa Yang Sudah Lunas</p>
        <h4 class="fw-bold">Total : <?= $lunas ?> Siswa</h4>
    </div>
    </div>
    </div>

    <div class="col-md-4">
    <div class="card border-0 shadow-sm">
    <div class="card-body text-center p-4">
        <p class="mb-1 text-muted">Siswa Yang Belum Lunas</p>
        <h4 class="fw-bold">Total : <?= $belum ?> Siswa</h4>
    </div>
    </div>
    </div>

</div>


<!-- Ilustrasi + Judul Aplikasi (sesuai foto) -->
<div class="text-center mt-3">

    <img src="/spp_sekolah/assets/image.png"
         alt="Ilustrasi SPP"
         style="max-width: 350px; width: 100%;">

    <h4 class="mt-3 fw-bold">
        APLIKASI PEMBAYARAN<br>SPP SEKOLAH 🏫
    </h4>

</div>


</div>


</body>
</html>