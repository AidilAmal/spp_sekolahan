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
tb_siswa.nama,
tb_spp.tahun,
tb_spp.nominal
FROM tb_pembayaran
JOIN tb_siswa ON tb_pembayaran.nisn = tb_siswa.nisn
JOIN tb_spp ON tb_pembayaran.id_spp = tb_spp.id_spp
ORDER BY tb_pembayaran.tgl_bayar DESC");

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); include "../template/header.php"; ?>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Pembayaran SPP</h2>

<div class="box">

<div class="mb-3 d-flex gap-2">

    <a href="tambah.php" class="btn btn-primary">
        <i class="fa fa-plus"></i>
        Tambah
    </a>

    <a href="#" class="btn btn-warning text-white"
       onclick="return cekPilih('ubah')">
        <i class="fa fa-edit"></i>
        Ubah
    </a>

    <a href="#" class="btn btn-danger"
       onclick="return cekPilih('hapus')">
        <i class="fa fa-trash"></i>
        Hapus
    </a>

</div>

<div class="table-responsive">
<table class="table table-striped table-bordered">

<thead class="table-dark">
<tr>
    <th>No</th>
    <th>ID Pembayaran</th>
    <th>Nama Siswa</th>
    <th>Tgl Bayar</th>
    <th>Tgl Terakhir</th>
    <th>Batas Bayar</th>
    <th>Jml Bulan</th>
    <th>Tahun SPP</th>
    <th>Nominal Bayar</th>
    <th>Jumlah Bayar</th>
    <th>Kembalian</th>
    <th>Status</th>
    <th>Pilih</th>
</tr>
</thead>

<tbody>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin();
$no = 1;
while($p = mysqli_fetch_assoc($data)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $p['id_pembayaran'] ?></td>
    <td><?= $p['nama'] ?></td>
    <td><?= $p['tgl_bayar'] ?></td>
    <td><?= $p['tgl_terakhir_bayar'] ?></td>
    <td><?= $p['batas_pembayaran'] ?></td>
    <td><?= $p['jumlah_bulan'] ?></td>
    <td><?= $p['tahun'] ?></td>
    <td>Rp <?= number_format($p['nominal_bayar'],0,',','.') ?></td>
    <td>Rp <?= number_format($p['jumlah_bayar'],0,',','.') ?></td>
    <td>Rp <?= number_format($p['kembalian'],0,',','.') ?></td>
    <td>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); if($p['status'] == 'Sudah Lunas'): ?>
        <span class="badge bg-success"><?= $p['status'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); else: ?>
        <span class="badge bg-danger"><?= $p['status'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endif; ?>
    </td>
    <td>
        <input type="radio" name="pilih_bayar" 
               class="form-check-input pilih-radio"
               value="<?= $p['id_pembayaran'] ?>">
    </td>
</tr>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); } ?>
</tbody>

</table>
</div>

</div>

</div>

<script>
function cekPilih(aksi) {
    const radio = document.querySelector('.pilih-radio:checked');
    if (!radio) {
        alert('Pilih data pembayaran terlebih dahulu!');
        return false;
    }
    const id = radio.value;
    if (aksi === 'ubah') {
        window.location.href = 'edit.php?id_pembayaran=' + id;
    } else if (aksi === 'hapus') {
        if (confirm('Yakin ingin menghapus data pembayaran ini?')) {
            window.location.href = 'hapus.php?id_pembayaran=' + id;
        }
    }
    return false;
}
</script>

</body>
</html>
