<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin();

include_once __DIR__ . "/../config/koneksi.php";

// Escape input teks agar aman dipakai di query
function esc($koneksi, $v){
    return mysqli_real_escape_string($koneksi, $v);
}

// Tanggal opsional: kosong -> NULL, terisi -> '2026-10-01'
function tglSql($koneksi, $v){
    return $v === '' ? "NULL" : "'" . esc($koneksi, $v) . "'";
}

if(isset($_POST['simpan'])){

    $id_pembayaran = esc($koneksi, $_POST['id_pembayaran']);
    $nisn          = esc($koneksi, $_POST['nisn']);
    $tgl_bayar     = tglSql($koneksi, $_POST['tgl_bayar']);
    $tgl_terakhir  = tglSql($koneksi, $_POST['tgl_terakhir_bayar']);
    $batas         = tglSql($koneksi, $_POST['batas_pembayaran']);
    $jumlah_bulan  = max(1, (int)$_POST['jumlah_bulan']);
    $id_spp        = esc($koneksi, $_POST['id_spp']);
    $id_petugas    = esc($koneksi, $_POST['id_petugas']);

    // Total yang harus dibayar dihitung di server: nominal SPP x jumlah bulan
    $spp_row = mysqli_fetch_assoc(mysqli_query($koneksi,
        "SELECT nominal FROM tb_spp WHERE id_spp='$id_spp'"));

    if(!$spp_row){
        echo "<script>alert('Data SPP tidak ditemukan.'); history.back();</script>";
        exit;
    }

    $nominal_bayar = (int)$spp_row['nominal'] * $jumlah_bulan;
    $jumlah_bayar  = max(0, (int)$_POST['jumlah_bayar']);

    // Status dan kembalian ditentukan otomatis
    if($jumlah_bayar >= $nominal_bayar){
        $kembalian = $jumlah_bayar - $nominal_bayar;
        $status    = 'Sudah Lunas';
    } else {
        $kembalian = 0;
        $status    = 'Belum Lunas';
    }

    mysqli_query($koneksi,
    "INSERT INTO tb_pembayaran VALUES(
    '$id_pembayaran',
    '$status',
    '$nisn',
    $tgl_bayar,
    $tgl_terakhir,
    $batas,
    '$jumlah_bulan',
    '$id_spp',
    '$nominal_bayar',
    '$jumlah_bayar',
    '$kembalian',
    '$id_petugas'
    )");

    header("location:index.php");
    exit;

}

// Ambil data untuk select
$siswa   = mysqli_query($koneksi, "SELECT * FROM tb_siswa");
$spp     = mysqli_query($koneksi, "SELECT * FROM tb_spp");
$petugas = mysqli_query($koneksi, "SELECT * FROM tb_petugas");

// Generate ID otomatis format PAY-0001
$last = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_pembayaran FROM tb_pembayaran ORDER BY id_pembayaran DESC LIMIT 1"));
if($last){
    preg_match('/\d+/', $last['id_pembayaran'], $m);
    $angka = intval($m[0]) + 1;
} else {
    $angka = 1;
}
$new_id = 'PAY-' . str_pad($angka, 4, '0', STR_PAD_LEFT);

?>

<?php include "../template/header.php"; ?>
<?php include "../template/sidebar.php"; ?>

<div class="content">

<h2>Tambah Pembayaran SPP</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>ID Pembayaran</label>
<input type="text" name="id_pembayaran" class="form-control"
       value="<?= $new_id ?>" readonly>
</div>

<div class="mb-3">
<label>Siswa (NISN)</label>
<select name="nisn" class="form-control" required>
<option value="">-- Pilih Siswa --</option>
<?php while($s = mysqli_fetch_assoc($siswa)): ?>
<option value="<?= $s['nisn'] ?>"><?= $s['nisn'] ?> - <?= $s['nama'] ?></option>
<?php endwhile; ?>
</select>
</div>

<div class="mb-3">
<label>SPP (Tahun)</label>
<select name="id_spp" id="id_spp" class="form-control" required>
<option value="">-- Pilih SPP --</option>
<?php while($sp = mysqli_fetch_assoc($spp)): ?>
<option value="<?= $sp['id_spp'] ?>" data-nominal="<?= $sp['nominal'] ?>">
    <?= $sp['tahun'] ?> - Rp <?= number_format($sp['nominal'],0,',','.') ?>
</option>
<?php endwhile; ?>
</select>
</div>

<div class="row">
<div class="col-md-4 mb-3">
<label>Tanggal Bayar</label>
<input type="date" name="tgl_bayar" class="form-control"
       value="<?= date('Y-m-d') ?>" required>
</div>
<div class="col-md-4 mb-3">
<label>Tgl Terakhir Bayar</label>
<input type="date" name="tgl_terakhir_bayar" class="form-control">
</div>
<div class="col-md-4 mb-3">
<label>Batas Pembayaran</label>
<input type="date" name="batas_pembayaran" class="form-control">
</div>
</div>

<div class="mb-3">
<label>Jumlah Bulan</label>
<input type="number" name="jumlah_bulan" id="jumlah_bulan" class="form-control"
       placeholder="Contoh: 3" min="1" max="12" required>
</div>

<div class="row">
<div class="col-md-6 mb-3">
<label>Total yang Harus Dibayar</label>
<input type="number" id="nominal_bayar" class="form-control"
       placeholder="Dihitung otomatis (SPP x jumlah bulan)" readonly>
</div>
<div class="col-md-6 mb-3">
<label>Uang yang Dibayarkan</label>
<input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control"
       placeholder="Uang yang dibayarkan siswa" min="0" required>
</div>
</div>

<div class="mb-3">
<small id="infoStatus" class="text-muted">Status ditentukan otomatis dari total dan uang yang dibayarkan.</small>
</div>

<div class="mb-3">
<label>Petugas</label>
<select name="id_petugas" class="form-control" required>
<option value="">-- Pilih Petugas --</option>
<?php while($pt = mysqli_fetch_assoc($petugas)): ?>
<option value="<?= $pt['id_petugas'] ?>"><?= $pt['nama_petugas'] ?></option>
<?php endwhile; ?>
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

<script>
// Hitung total dan tampilkan status sementara (server tetap menghitung ulang saat simpan)
function hitung(){
    const opt   = document.getElementById('id_spp').selectedOptions[0];
    const nom   = parseInt(opt.dataset.nominal) || 0;
    const bulan = parseInt(document.getElementById('jumlah_bulan').value) || 0;
    const bayar = parseInt(document.getElementById('jumlah_bayar').value) || 0;
    const total = nom * bulan;
    const info  = document.getElementById('infoStatus');

    document.getElementById('nominal_bayar').value = total > 0 ? total : '';

    if (total === 0 || bayar === 0) {
        info.textContent = 'Status ditentukan otomatis dari total dan uang yang dibayarkan.';
    } else if (bayar >= total) {
        info.textContent = 'Status: Sudah Lunas, kembalian Rp ' + (bayar - total).toLocaleString('id-ID');
    } else {
        info.textContent = 'Status: Belum Lunas, kurang Rp ' + (total - bayar).toLocaleString('id-ID');
    }
}
['id_spp', 'jumlah_bulan', 'jumlah_bayar'].forEach(function(id){
    document.getElementById(id).addEventListener('input', hitung);
    document.getElementById(id).addEventListener('change', hitung);
});
</script>

</body>
</html>