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

$id_pembayaran = esc($koneksi, $_GET['id_pembayaran'] ?? '');

$data = mysqli_query($koneksi,
"SELECT * FROM tb_pembayaran WHERE id_pembayaran='$id_pembayaran'");
$p = mysqli_fetch_assoc($data);

// Data pembayaran tidak ditemukan
if(!$p){
    header("location:index.php");
    exit;
}

// Nominal SPP per bulan (dipakai untuk menghitung total)
$spp_row = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT nominal FROM tb_spp WHERE id_spp='" . esc($koneksi, $p['id_spp']) . "'"));
$nominal_spp = $spp_row ? (int)$spp_row['nominal'] : 0;

if(isset($_POST['update'])){

    if($nominal_spp === 0){
        echo "<script>alert('Data SPP tidak ditemukan.'); history.back();</script>";
        exit;
    }

    $jumlah_bulan  = max(1, (int)$_POST['jumlah_bulan']);
    $nominal_bayar = $nominal_spp * $jumlah_bulan;          // total dihitung server
    $jumlah_bayar  = max(0, (int)$_POST['jumlah_bayar']);

    // Status dan kembalian ditentukan otomatis
    if($jumlah_bayar >= $nominal_bayar){
        $kembalian = $jumlah_bayar - $nominal_bayar;
        $status    = 'Sudah Lunas';
    } else {
        $kembalian = 0;
        $status    = 'Belum Lunas';
    }

    $tgl_bayar    = tglSql($koneksi, $_POST['tgl_bayar']);
    $tgl_terakhir = tglSql($koneksi, $_POST['tgl_terakhir_bayar']);
    $batas        = tglSql($koneksi, $_POST['batas_pembayaran']);

    mysqli_query($koneksi,
    "UPDATE tb_pembayaran SET
    tgl_bayar=$tgl_bayar,
    tgl_terakhir_bayar=$tgl_terakhir,
    batas_pembayaran=$batas,
    jumlah_bulan='$jumlah_bulan',
    nominal_bayar='$nominal_bayar',
    jumlah_bayar='$jumlah_bayar',
    kembalian='$kembalian',
    status='$status'
    WHERE id_pembayaran='$id_pembayaran'");

    header("location:index.php");
    exit;

}

?>

<?php include "../template/header.php"; ?>
<?php include "../template/sidebar.php"; ?>

<div class="content">

<h2>Edit Pembayaran SPP</h2>

<div class="box">

<form method="POST">

<div class="mb-3">
<label>ID Pembayaran</label>
<input type="text" class="form-control" value="<?= $p['id_pembayaran'] ?>" readonly>
</div>

<div class="mb-3">
<label>NISN Siswa</label>
<input type="text" class="form-control" value="<?= $p['nisn'] ?>" readonly>
</div>

<div class="row">
<div class="col-md-4 mb-3">
<label>Tanggal Bayar</label>
<input type="date" name="tgl_bayar" class="form-control" value="<?= $p['tgl_bayar'] ?>">
</div>
<div class="col-md-4 mb-3">
<label>Tgl Terakhir Bayar</label>
<input type="date" name="tgl_terakhir_bayar" class="form-control" value="<?= $p['tgl_terakhir_bayar'] ?>">
</div>
<div class="col-md-4 mb-3">
<label>Batas Pembayaran</label>
<input type="date" name="batas_pembayaran" class="form-control" value="<?= $p['batas_pembayaran'] ?>">
</div>
</div>

<div class="mb-3">
<label>Jumlah Bulan</label>
<input type="number" name="jumlah_bulan" id="jumlah_bulan" class="form-control"
       min="1" max="12" value="<?= $p['jumlah_bulan'] ?>" required>
</div>

<div class="row">
<div class="col-md-6 mb-3">
<label>Total yang Harus Dibayar</label>
<input type="number" id="nominal_bayar" class="form-control"
       value="<?= $p['nominal_bayar'] ?>" readonly>
</div>
<div class="col-md-6 mb-3">
<label>Uang yang Dibayarkan</label>
<input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control"
       min="0" value="<?= $p['jumlah_bayar'] ?>" required>
</div>
</div>

<div class="mb-3">
<small id="infoStatus" class="text-muted">Status saat ini: <?= $p['status'] ?> (ditentukan otomatis saat disimpan)</small>
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

<script>
const nominalSpp = <?= $nominal_spp ?>;

// Hitung total dan tampilkan status sementara (server tetap menghitung ulang saat update)
function hitung(){
    const bulan = parseInt(document.getElementById('jumlah_bulan').value) || 0;
    const bayar = parseInt(document.getElementById('jumlah_bayar').value) || 0;
    const total = nominalSpp * bulan;
    const info  = document.getElementById('infoStatus');

    document.getElementById('nominal_bayar').value = total > 0 ? total : '';

    if (total === 0) {
        info.textContent = '';
    } else if (bayar >= total) {
        info.textContent = 'Status: Sudah Lunas, kembalian Rp ' + (bayar - total).toLocaleString('id-ID');
    } else {
        info.textContent = 'Status: Belum Lunas, kurang Rp ' + (total - bayar).toLocaleString('id-ID');
    }
}
['jumlah_bulan', 'jumlah_bayar'].forEach(function(id){
    document.getElementById(id).addEventListener('input', hitung);
});
hitung();
</script>

</body>
</html>