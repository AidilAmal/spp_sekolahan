<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin();

include_once __DIR__ . "/../config/koneksi.php";

if(!isset($koneksi)){
    die("Koneksi belum terbaca");
}

$data = mysqli_query($koneksi,
"SELECT 
tb_pembayaran.*,
tb_siswa.nama AS nama_siswa,
tb_siswa.nis,
tb_siswa.nama_kelas,
tb_kelas.komp_keahlian,
tb_spp.tahun,
tb_spp.nominal,
tb_petugas.nama_petugas

FROM tb_pembayaran
JOIN tb_siswa ON tb_pembayaran.nisn = tb_siswa.nisn
JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas
JOIN tb_spp ON tb_pembayaran.id_spp = tb_spp.id_spp
JOIN tb_petugas ON tb_pembayaran.id_petugas = tb_petugas.id_petugas
ORDER BY tb_pembayaran.tgl_bayar DESC");

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); include "../template/header.php"; ?>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Detail Pembayaran SPP</h2>

<div class="box">

<div class="table-responsive">
<table class="table table-striped table-bordered">

<thead class="table-dark">
<tr>
    <th>No</th>
    <th>ID Pembayaran</th>
    <th>NISN</th>
    <th>NIS</th>
    <th>Nama Siswa</th>
    <th>Kelas</th>
    <th>Kompetensi</th>
    <th>Tahun SPP</th>
    <th>Nominal SPP</th>
    <th>Tgl Bayar</th>
    <th>Tgl Terakhir</th>
    <th>Batas Bayar</th>
    <th>Jml Bulan</th>
    <th>Jumlah Bayar</th>
    <th>Kembalian</th>
    <th>Status</th>
    <th>Petugas</th>
</tr>
</thead>

<tbody>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin();
$no = 1;
while($d = mysqli_fetch_assoc($data)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $d['id_pembayaran'] ?></td>
    <td><?= $d['nisn'] ?></td>
    <td><?= $d['nis'] ?></td>
    <td><?= $d['nama_siswa'] ?></td>
    <td><?= $d['nama_kelas'] ?></td>
    <td><?= $d['komp_keahlian'] ?></td>
    <td><?= $d['tahun'] ?></td>
    <td>Rp <?= number_format($d['nominal'],0,',','.') ?></td>
    <td><?= $d['tgl_bayar'] ?></td>
    <td><?= $d['tgl_terakhir_bayar'] ?></td>
    <td><?= $d['batas_pembayaran'] ?></td>
    <td><?= $d['jumlah_bulan'] ?> bulan</td>
    <td>Rp <?= number_format($d['jumlah_bayar'],0,',','.') ?></td>
    <td>Rp <?= number_format($d['kembalian'],0,',','.') ?></td>
    <td>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); if($d['status'] == 'Sudah Lunas'): ?>
        <span class="badge bg-success"><?= $d['status'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); else: ?>
        <span class="badge bg-danger"><?= $d['status'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endif; ?>
    </td>
    <td><?= $d['nama_petugas'] ?></td>
</tr>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); } ?>
</tbody>

</table>
</div>

</div>

</div>

</body>
</html>
