<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

$id_petugas = $_GET['id_petugas'];

$data = mysqli_query($koneksi, "SELECT * FROM tb_petugas WHERE id_petugas='$id_petugas'");
$pt = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){

    $username = $_POST['username'];
    $nama     = $_POST['nama_petugas'];
    $level    = $_POST['level'];
    $password = $_POST['password'];

    mysqli_query($koneksi,
    "UPDATE tb_petugas SET
    username='$username',
    password='$password',
    nama_petugas='$nama',
    level='$level'
    WHERE id_petugas='$id_petugas'");

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

<h2>Edit Data Petugas</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>ID Petugas</label>
<input type="text" class="form-control" value="<?= $pt['id_petugas'] ?>" readonly>
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" value="<?= $pt['username'] ?>">
</div>

<div class="mb-3">
<label>Password (isi jika ingin ganti)</label>
<input type="password" name="password" class="form-control" value="<?= $pt['password'] ?>">
</div>

<div class="mb-3">
<label>Nama Petugas</label>
<input type="text" name="nama_petugas" class="form-control" value="<?= $pt['nama_petugas'] ?>">
</div>

<div class="mb-3">
<label>Level</label>
<select name="level" class="form-control">
<option value="admin" <?= $pt['level']=='admin'?'selected':'' ?>>Admin</option>
<option value="petugas" <?= $pt['level']=='petugas'?'selected':'' ?>>Petugas</option>
<option value="siswa" <?= $pt['level']=='siswa'?'selected':'' ?>>Siswa</option>
</select>
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
