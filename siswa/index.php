<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

include_once __DIR__ . "/../config/koneksi.php";

if(!isset($koneksi)){
    die("Koneksi belum terbaca");
}

// Pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT 
tb_siswa.*,
tb_kelas.komp_keahlian

FROM tb_siswa

JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas";

if($search != ''){
    $sql .= " WHERE tb_siswa.nama LIKE '%$search%' 
              OR tb_siswa.nisn LIKE '%$search%'
              OR tb_siswa.nis LIKE '%$search%'";
}

$data = mysqli_query($koneksi, $sql);

?>


<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/header.php"; ?>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); include "../template/sidebar.php"; ?>


<div class="content">

<h2>Data Siswa</h2>

<div class="box">

<!-- Tombol aksi di atas tabel (sesuai foto) -->
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

<!-- Form pencarian -->
<div class="mb-3 d-flex justify-content-end">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" 
               placeholder="Cari siswa..." 
               value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn btn-secondary">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<!-- Keterangan baris terpilih -->
<div id="infoTerpilih" class="alert alert-info py-1 mb-2" style="display:none;">
    <small><i class="fa fa-check-circle"></i> Baris dipilih: <strong id="namaRpilih"></strong></small>
</div>

<div class="table-responsive">
<table class="table table-striped table-bordered" id="tblSiswa">

<thead class="table-dark">
<tr>
    <th>NIS</th>
    <th>NISN</th>
    <th>Nama</th>
    <th>Kode Kelas</th>
    <th>Kompetensi Keahlian</th>
    <th>Kelas</th>
    <th>Alamat</th>
    <th>No HP</th>
    <th>Kode SPP</th>
</tr>
</thead>

<tbody>
<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin();

while($s=mysqli_fetch_assoc($data)){

?>

<tr class="baris-siswa" 
    data-nisn="<?= $s['nisn'] ?>"
    data-nama="<?= $s['nama'] ?>"
    style="cursor:pointer;">
    <td><?= $s['nis'] ?></td>
    <td><?= $s['nisn'] ?></td>
    <td><?= $s['nama'] ?></td>
    <td><?= $s['id_kelas'] ?></td>
    <td><?= $s['komp_keahlian'] ?></td>
    <td><?= $s['nama_kelas'] ?></td>
    <td><?= $s['alamat'] ?></td>
    <td><?= $s['no_telp'] ?></td>
    <td><?= $s['id_spp'] ?></td>
</tr>

<?php
include_once __DIR__ . '/../config/auth.php';
cekAdmin(); } ?>
</tbody>

</table>
</div>


</div>

</div>

<!-- Simpan NISN terpilih -->
<input type="hidden" id="nisnTerpilih" value="">

<!-- Modal Konfirmasi Hapus (di tengah) -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">
          <i class="fa fa-trash"></i> Konfirmasi Hapus
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center py-4">
        <i class="fa fa-circle-exclamation text-danger fa-3x mb-3"></i>
        <p class="mb-1">Yakin ingin menghapus data siswa:</p>
        <strong id="namaHapus" class="fs-5"></strong>
        <p class="text-muted mt-2 mb-0"><small>Data yang dihapus tidak bisa dikembalikan!</small></p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
          <i class="fa fa-times"></i> Batal
        </button>
        <a href="#" id="btnKonfirmasiHapus" class="btn btn-danger px-4">
          <i class="fa fa-trash"></i> Ya, Hapus!
        </a>
      </div>
    </div>
  </div>
</div>

<script>
// Klik baris untuk memilih
document.querySelectorAll('.baris-siswa').forEach(function(baris) {
    baris.addEventListener('click', function() {
        // Hapus highlight sebelumnya
        document.querySelectorAll('.baris-siswa').forEach(function(b) {
            b.classList.remove('table-warning');
        });

        // Highlight baris yang diklik
        this.classList.add('table-warning');

        // Simpan NISN yang dipilih
        document.getElementById('nisnTerpilih').value = this.dataset.nisn;

        // Tampilkan info
        document.getElementById('namaRpilih').textContent = this.dataset.nama;
        document.getElementById('infoTerpilih').style.display = 'block';
    });
});

// Fungsi tombol Ubah dan Hapus
function cekPilih(aksi) {
    const nisn = document.getElementById('nisnTerpilih').value;
    const nama = document.getElementById('namaRpilih').textContent;

    if (!nisn) {
        alert('Klik baris siswa terlebih dahulu untuk memilih!');
        return false;
    }

    if (aksi === 'ubah') {
        window.location.href = 'edit.php?nisn=' + nisn;
    } else if (aksi === 'hapus') {
        // Tampilkan modal di tengah layar
        document.getElementById('namaHapus').textContent = nama;
        document.getElementById('btnKonfirmasiHapus').href = 'hapus.php?nisn=' + nisn;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    }
    return false;
}
</script>

</body>
</html>