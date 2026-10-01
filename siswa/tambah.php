<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";


if(isset($_POST['simpan'])){

    // Escape semua input teks agar aman dipakai di query
    $nisn     = mysqli_real_escape_string($koneksi, trim($_POST['nisn']));
    $nis      = mysqli_real_escape_string($koneksi, trim($_POST['nis']));
    $nama     = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $alamat   = mysqli_real_escape_string($koneksi, trim($_POST['alamat']));
    $no_telp  = trim($_POST['no_telp']);
    $id_spp   = mysqli_real_escape_string($koneksi, $_POST['id_spp']);

    // Validasi di sisi server: no telepon harus 11-13 digit angka
    if(!preg_match('/^[0-9]{11,13}$/', $no_telp)){
        echo "<script>alert('No telepon harus 11 sampai 13 digit angka.'); history.back();</script>";
        exit;
    }
    $no_telp = mysqli_real_escape_string($koneksi, $no_telp);

    // Ambil nama_kelas dari id_kelas yang dipilih
    $kelas_dipilih = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT nama_kelas FROM tb_kelas WHERE id_kelas='$id_kelas'"));
    $nama_kelas_val = $kelas_dipilih ? $kelas_dipilih['nama_kelas'] : '';

    mysqli_query($koneksi,
    "INSERT INTO tb_siswa VALUES(
    '$nisn',
    '$nis',
    '$nama',
    '$id_kelas',
    '$nama_kelas_val',
    '$alamat',
    '$no_telp',
    '$id_spp'
    )");

    header("location:index.php");
    exit;
}


$kelas = mysqli_query($koneksi, "SELECT * FROM tb_kelas");
$spp   = mysqli_query($koneksi, "SELECT * FROM tb_spp");

?>

<?php include "../template/header.php"; ?>
<?php include "../template/sidebar.php"; ?>


<div class="content">

<h2>Tambah Data Siswa</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>NISN</label>
<input type="text" name="nisn" class="form-control" required>
</div>

<div class="mb-3">
<label>NIS</label>
<input type="text" name="nis" class="form-control" required>
</div>

<div class="mb-3">
<label>Nama Siswa</label>
<input type="text" name="nama" class="form-control" required>
</div>

<div class="mb-3">
<label>Kelas</label>
<select name="id_kelas" class="form-control" required>
<?php while($k = mysqli_fetch_assoc($kelas)){ ?>
<option value="<?= $k['id_kelas'] ?>"><?= $k['nama_kelas'] ?></option>
<?php } ?>
</select>
</div>

<div class="mb-3">
<label>Alamat</label>
<textarea name="alamat" class="form-control" required></textarea>
</div>

<div class="mb-3">
<label>No Telepon</label>
<input type="text" name="no_telp" class="form-control"
       required pattern="[0-9]{11,13}" minlength="11" maxlength="13"
       inputmode="numeric" placeholder="Contoh: 081234567890"
       title="No telepon harus 11 sampai 13 digit angka">
</div>

<div class="mb-3">
<label>SPP</label>
<select name="id_spp" class="form-control" required>
<?php while($s = mysqli_fetch_assoc($spp)){ ?>
<option value="<?= $s['id_spp'] ?>"><?= $s['tahun']." - ".$s['nominal'] ?></option>
<?php } ?>
</select>
</div>

<button name="simpan" class="btn btn-success">Simpan</button>

<a href="index.php" class="btn btn-secondary">Kembali</a>

</form>

</div>

</div>