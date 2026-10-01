<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

if(isset($_POST['simpan'])){

    $id_kelas   = $_POST['id_kelas'];
    $nama_kelas = $_POST['nama_kelas'];
    $kompetensi = $_POST['komp_keahlian'];

    mysqli_query($koneksi,
    "INSERT INTO tb_kelas VALUES(
    '$id_kelas',
    '$nama_kelas',
    '$kompetensi'
    )");

    header("location:index.php");

}

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/header.php"; ?>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Tambah Data Kelas</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>Kode Kelas</label>
<input type="text" name="id_kelas" class="form-control" placeholder="Contoh: K006" required>
</div>

<div class="mb-3">
<label>Nama Kelas</label>
<input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: X TGB 1" required>
</div>

<div class="mb-3">
<label>Kompetensi Keahlian</label>
<input type="text" name="komp_keahlian" class="form-control" placeholder="Contoh: Tata Boga" required>
</div>

<button name="simpan" class="btn btn-success">
<i class="fa fa-save"></i> Simpan
</button>

<a href="index.php" class="btn btn-secondary">
<i class="fa fa-arrow-left"></i> Kembali
</a>

</form>

</div>

</div>

</body>
</html>
