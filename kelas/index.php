<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

if(!isset($koneksi)){
    die("Koneksi belum terbaca");
}

$data = mysqli_query($koneksi, "SELECT * FROM tb_kelas");

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/header.php"; ?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Data Kelas</h2>

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
    <th>Kode Kelas</th>
    <th>Nama Kelas</th>
    <th>Kompetensi Keahlian</th>
    <th>Pilih</th>
</tr>
</thead>

<tbody>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();
$no = 1;
while($k = mysqli_fetch_assoc($data)){
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $k['id_kelas'] ?></td>
    <td><?= $k['nama_kelas'] ?></td>
    <td><?= $k['komp_keahlian'] ?></td>
    <td>
        <input type="radio" name="pilih_kelas" 
               class="form-check-input pilih-radio"
               value="<?= $k['id_kelas'] ?>">
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
        alert('Pilih data kelas terlebih dahulu!');
        return false;
    }
    const id = radio.value;
    if (aksi === 'ubah') {
        window.location.href = 'edit.php?id_kelas=' + id;
    } else if (aksi === 'hapus') {
        if (confirm('Yakin ingin menghapus data kelas ini?')) {
            window.location.href = 'hapus.php?id_kelas=' + id;
        }
    }
    return false;
}
</script>

</body>
</html>
