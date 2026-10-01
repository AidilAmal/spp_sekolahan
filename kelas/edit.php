<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

$id_kelas = $_GET['id_kelas'];

$data = mysqli_query($koneksi, "SELECT * FROM tb_kelas WHERE id_kelas='$id_kelas'");
$kelas = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    mysqli_query($koneksi,
    "UPDATE tb_kelas SET
    nama_kelas='$_POST[nama_kelas]',
    komp_keahlian='$_POST[komp_keahlian]'
    WHERE id_kelas='$id_kelas'");

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

<h2>Edit Data Kelas</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>Kode Kelas</label>
<input type="text" class="form-control" value="<?= $kelas['id_kelas'] ?>" readonly>
</div>

<div class="mb-3">
<label>Nama Kelas</label>
<input type="text" name="nama_kelas" class="form-control" 
       value="<?= $kelas['nama_kelas'] ?>" required>
</div>

<div class="mb-3">
<label>Kompetensi Keahlian</label>
<input type="text" name="komp_keahlian" class="form-control" 
       value="<?= $kelas['komp_keahlian'] ?>" required>
</div>

<button name="update" class="btn btn-warning">
<i class="fa fa-save"></i> Update
</button>

<a href="index.php" class="btn btn-secondary">
<i class="fa fa-arrow-left"></i> Kembali
</a>

</form>

</div>

</div>

</body>
</html>
