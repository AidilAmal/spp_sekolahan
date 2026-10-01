<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";


$nisn = mysqli_real_escape_string($koneksi, $_GET['nisn']);

$data  = mysqli_query($koneksi, "SELECT * FROM tb_siswa WHERE nisn='$nisn'");
$siswa = mysqli_fetch_assoc($data);


if(isset($_POST['update'])){

    $nis     = mysqli_real_escape_string($koneksi, trim($_POST['nis']));
    $nama    = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $alamat  = mysqli_real_escape_string($koneksi, trim($_POST['alamat']));
    $no_telp = trim($_POST['no_telp']);

    // Validasi di sisi server: no telepon harus 11-13 digit angka
    if(!preg_match('/^[0-9]{11,13}$/', $no_telp)){
        echo "<script>alert('No telepon harus 11 sampai 13 digit angka.'); history.back();</script>";
        exit;
    }
    $no_telp = mysqli_real_escape_string($koneksi, $no_telp);

    mysqli_query($koneksi,
    "UPDATE tb_siswa SET
    nis='$nis',
    nama='$nama',
    alamat='$alamat',
    no_telp='$no_telp'
    WHERE nisn='$nisn'");

    header("location:index.php");
    exit;
}

?>

<?php include "../template/header.php"; ?>
<?php include "../template/sidebar.php"; ?>


<div class="content">

<h2>Edit Data Siswa</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>NIS</label>
<input class="form-control bg-light" name="nis" readonly
       value="<?= htmlspecialchars($siswa['nis']) ?>">
<small class="text-muted">Tidak dapat diubah</small>
</div>
</div>

<div class="mb-3">
<label>Nama</label>
<input class="form-control" name="nama" required
       value="<?= htmlspecialchars($siswa['nama']) ?>">
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control" required><?= htmlspecialchars($siswa['alamat']) ?></textarea>
</div>

<div class="mb-3">
<label>No Telepon</label>
<input class="form-control" name="no_telp"
       required pattern="[0-9]{11,13}" minlength="11" maxlength="13"
       inputmode="numeric"
       title="No telepon harus 11 sampai 13 digit angka"
       value="<?= htmlspecialchars($siswa['no_telp']) ?>">
</div>

<button name="update" class="btn btn-warning">Update</button>

<a href="index.php" class="btn btn-secondary">Kembali</a>

</form>

</div>

</div>
