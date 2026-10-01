<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

if(isset($_POST['simpan'])){

    $id_petugas  = $_POST['id_petugas'];
    $username    = $_POST['username'];
    $password    = $_POST['password'];
    $nama        = $_POST['nama_petugas'];
    $level       = $_POST['level'];

    mysqli_query($koneksi,
    "INSERT INTO tb_petugas VALUES(
    '$id_petugas',
    '$username',
    '$password',
    '$nama',
    '$level'
    )");

    header("location:index.php");

}

// Generate ID otomatis
$last = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_petugas FROM tb_petugas ORDER BY id_petugas DESC LIMIT 1"));
if($last){
    preg_match('/\d+/', $last['id_petugas'], $m);
    $angka = intval($m[0]) + 1;
} else {
    $angka = 1;
}
$new_id = 'P' . str_pad($angka, 3, '0', STR_PAD_LEFT);

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/header.php"; ?>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Tambah Data Petugas</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>ID Petugas</label>
<input type="text" name="id_petugas" class="form-control" 
       value="<?= $new_id ?>" readonly>
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Nama Petugas</label>
<input type="text" name="nama_petugas" class="form-control" required>
</div>

<div class="mb-3">
<label>Level</label>
<select name="level" class="form-control" required>
<option value="admin">Admin</option>
<option value="petugas">Petugas</option>
<option value="siswa">Siswa</option>
</select>
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
