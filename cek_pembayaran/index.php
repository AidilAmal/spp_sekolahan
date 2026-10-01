<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin();

include_once __DIR__ . "/../config/koneksi.php";

// ── Cari siswa berdasarkan nama ──────────────────────────
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

$hasil_nama = [];
if($keyword != ''){
    $q = mysqli_query($koneksi,
    "SELECT tb_siswa.nisn, tb_siswa.nama, tb_siswa.nama_kelas, tb_siswa.no_telp
     FROM tb_siswa
     WHERE tb_siswa.nama LIKE '%$keyword%'
     LIMIT 10");
    while($r = mysqli_fetch_assoc($q)){
        $hasil_nama[] = $r;
    }
}

// ── Cek pembayaran berdasarkan NISN (simpan di session agar tidak hilang) ──
//session_start();

if(isset($_POST['cek']) && $_POST['nisn_cek'] != ''){
    $nisn_cek = $_POST['nisn_cek'];

    // Ambil data sudah lunas untuk NISN ini
    $q_lunas = mysqli_query($koneksi,
    "SELECT tb_pembayaran.*, tb_siswa.nama, tb_siswa.no_telp
     FROM tb_pembayaran
     JOIN tb_siswa ON tb_pembayaran.nisn = tb_siswa.nisn
     WHERE tb_pembayaran.nisn='$nisn_cek'
     AND tb_pembayaran.status='Sudah Lunas'");

    while($r = mysqli_fetch_assoc($q_lunas)){
        // Cegah duplikat
        $key = $r['id_pembayaran'];
        $_SESSION['lunas'][$key] = $r;
    }

    // Ambil data belum lunas untuk NISN ini
    $q_belum = mysqli_query($koneksi,
    "SELECT tb_pembayaran.*, tb_siswa.nama, tb_siswa.no_telp
     FROM tb_pembayaran
     JOIN tb_siswa ON tb_pembayaran.nisn = tb_siswa.nisn
     WHERE tb_pembayaran.nisn='$nisn_cek'
     AND tb_pembayaran.status='Belum Lunas'");

    while($r = mysqli_fetch_assoc($q_belum)){
        $key = $r['id_pembayaran'];
        $_SESSION['belum'][$key] = $r;
    }
}




$lunas_list = isset($_SESSION['lunas']) ? $_SESSION['lunas'] : [];
$belum_list = isset($_SESSION['belum']) ? $_SESSION['belum'] : [];

$nisn_cek = isset($_POST['nisn_cek']) ? $_POST['nisn_cek'] : '';

?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); include "../template/header.php"; ?>
<?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); include "../template/sidebar.php"; ?>

<div class="content">

<h2>Cek Pembayaran</h2>

<!-- ═══ BARIS ATAS: 2 KOLOM (form kiri | hasil kanan) ═══ -->
<div class="row">

    <!-- ── KOLOM KIRI: Form pencarian & cek ── -->
    <div class="col-md-6">
    <div class="box mb-3">

        <!-- Form 1: Cari NISN dengan nama -->
        <h5>Cari NISN dengan memasukan Namamu</h5>
        <form method="POST" class="d-flex gap-2 mb-4">
            <input type="text" name="keyword" class="form-control"
                   placeholder="Masukkan nama siswa..."
                   value="<?= htmlspecialchars($keyword) ?>">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-search"></i>
            </button>
            <button type="reset" onclick="this.form.keyword.value=''; this.form.submit();"
                    class="btn btn-secondary">
                <i class="fa fa-times"></i>
            </button>
        </form>

        <!-- Form 2: Cek pembayaran berdasarkan NISN -->
        <h5>Cek Pembayaran Menggunakan NISNmu</h5>
        <form method="POST" class="mb-2">
            <input type="text" name="nisn_cek" class="form-control mb-2"
                   placeholder="Masukkan NISN..."
                   value="<?= htmlspecialchars($nisn_cek) ?>">
            <button type="submit" name="cek" class="btn btn-success w-100">
                CEK PEMBAYARAN
            </button>
        </form>



    </div>
    </div>

    <!-- ── KOLOM KANAN: Data Hasil Pencarian Nama ── -->
    <div class="col-md-6">
    <div class="box mb-3">
        <h5>Data Hasil Pencarian</h5>

        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); if(!empty($hasil_nama)): ?>
        <div class="table-responsive">
        <table class="table table-sm table-bordered">
        <thead class="table-secondary">
        <tr>
            <th>NISN</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No Telp</th>
        </tr>
        </thead>
        <tbody>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); foreach($hasil_nama as $h): ?>
        <tr>
            <td><?= $h['nisn'] ?></td>
            <td><?= $h['nama'] ?></td>
            <td><?= $h['nama_kelas'] ?></td>
            <td><?= $h['no_telp'] ?></td>
        </tr>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endforeach; ?>
        </tbody>
        </table>
        </div>

        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); elseif($keyword != ''): ?>
        <p class="text-muted"><i class="fa fa-info-circle"></i> Tidak ada data ditemukan.</p>

        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); else: ?>
        <p class="text-muted"><i class="fa fa-arrow-left"></i> Hasil pencarian akan muncul di sini.</p>
        <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endif; ?>

    </div>
    </div>

</div><!-- end row atas -->


<!-- ═══ BARIS BAWAH: 2 tabel Lunas & Belum Lunas (selalu muncul) ═══ -->
<div class="row">

    <!-- Siswa Sudah Lunas -->
    <div class="col-md-6">
    <div class="box">
    <h5 class="text-success">
        <i class="fa fa-check-circle"></i>
        Siswa Yang Sudah Lunas
    </h5>
    <div class="table-responsive">
    <table class="table table-sm table-bordered table-striped">
    <thead class="table-success">
    <tr>
        <th>NIP</th>
        <th>Tgl Bayar</th>
        <th>Tgl Terakhir</th>
        <th>Status</th>
        <th>Jml Bln</th>
        <th>Nama</th>
        <th>No Telp</th>
    </tr>
    </thead>
    <tbody>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); if(!empty($lunas_list)): ?>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); foreach($lunas_list as $l): ?>
    <tr>
        <td><?= $l['id_pembayaran'] ?></td>
        <td><?= $l['tgl_bayar'] ?></td>
        <td><?= $l['tgl_terakhir_bayar'] ?></td>
        <td><span class="badge bg-success"><?= $l['status'] ?></span></td>
        <td><?= $l['jumlah_bulan'] ?></td>
        <td><?= $l['nama'] ?></td>
        <td><?= $l['no_telp'] ?></td>
    </tr>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endforeach; ?>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); else: ?>
    <tr><td colspan="7" class="text-center text-muted">Belum ada data. Masukkan NISN lalu klik CEK.</td></tr>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endif; ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>

    <!-- Siswa Belum Lunas -->
    <div class="col-md-6">
    <div class="box">
    <h5 class="text-danger">
        <i class="fa fa-times-circle"></i>
        Siswa Yang Belum Lunas
    </h5>
    <div class="table-responsive">
    <table class="table table-sm table-bordered table-striped">
    <thead class="table-danger">
    <tr>
        <th>NIP</th>
        <th>Tgl Bayar</th>
        <th>Tgl Terakhir</th>
        <th>Status</th>
        <th>Jml Bln</th>
        <th>Nama</th>
        <th>No Telp</th>
    </tr>
    </thead>
    <tbody>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); if(!empty($belum_list)): ?>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); foreach($belum_list as $b): ?>
    <tr>
        <td><?= $b['id_pembayaran'] ?></td>
        <td><?= $b['tgl_bayar'] ?></td>
        <td><?= $b['tgl_terakhir_bayar'] ?></td>
        <td><span class="badge bg-danger"><?= $b['status'] ?></span></td>
        <td><?= $b['jumlah_bulan'] ?></td>
        <td><?= $b['nama'] ?></td>
        <td><?= $b['no_telp'] ?></td>
    </tr>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endforeach; ?>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); else: ?>
    <tr><td colspan="7" class="text-center text-muted">Belum ada data. Masukkan NISN lalu klik CEK.</td></tr>
    <?php
include_once __DIR__ . '/../config/auth.php';
cekLogin(); endif; ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>

</div><!-- end row bawah -->

</div><!-- end content -->

</body>
</html>
