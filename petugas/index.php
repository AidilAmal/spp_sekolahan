<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

if(!isset($koneksi)){
    die("Koneksi belum terbaca");
}

$data = mysqli_query($koneksi, "SELECT * FROM tb_petugas");

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/header.php"; ?>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Data Petugas</h2>

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
    <th>ID Petugas</th>
    <th>Username</th>
    <th>Nama Petugas</th>
    <th>Level</th>
    <th>Pilih</th>
</tr>
</thead>

<tbody>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();
$no = 1;
while($pt = mysqli_fetch_assoc($data)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $pt['id_petugas'] ?></td>
    <td><?= $pt['username'] ?></td>
    <td><?= $pt['nama_petugas'] ?></td>
    <td>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); if($pt['level'] == 'admin'): ?>
        <span class="badge bg-danger"><?= $pt['level'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); elseif($pt['level'] == 'petugas'): ?>
        <span class="badge bg-primary"><?= $pt['level'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); else: ?>
        <span class="badge bg-secondary"><?= $pt['level'] ?></span>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); endif; ?>
    </td>
    <td>
        <input type="radio" name="pilih_petugas" 
               class="form-check-input pilih-radio"
               value="<?= $pt['id_petugas'] ?>">
    </td>
</tr>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); } ?>
</tbody>

</table>
</div>

</div>

</div>

<script>
function cekPilih(aksi) {
    const radio = document.querySelector('.pilih-radio:checked');
    if (!radio) {
        alert('Pilih data petugas terlebih dahulu!');
        return false;
    }
    const id = radio.value;
    if (aksi === 'ubah') {
        window.location.href = 'edit.php?id_petugas=' + id;
    } else if (aksi === 'hapus') {
        if (confirm('Yakin ingin menghapus data petugas ini?')) {
            window.location.href = 'hapus.php?id_petugas=' + id;
        }
    }
    return false;
}
</script>

</body>
</html>
