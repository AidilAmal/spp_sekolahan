<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$level = $_SESSION['level'] ?? '';
?>

<div class="sidebar">

<h4>
<i class="fa fa-school"></i>
Menu Admin
</h4>


<a href="/spp_sekolah/dashboard.php">
<i class="fa fa-home"></i>
Dashboard
</a>


<?php if($level === 'admin'): ?>
<a href="/spp_sekolah/kelas/index.php">
<i class="fa fa-building"></i>
Data Kelas
</a>
<?php endif; ?>


<?php if($level === 'admin'): ?>
<a href="/spp_sekolah/siswa/index.php">
<i class="fa fa-users"></i>
Data Siswa
</a>
<?php endif; ?>


<a href="/spp_sekolah/cek_pembayaran/index.php">
<i class="fa fa-search"></i>
Cek Pembayaran
</a>


<a href="/spp_sekolah/pembayaran/index.php">
<i class="fa fa-money-bill"></i>
Pembayaran
</a>


<a href="/spp_sekolah/detail/index.php">
<i class="fa fa-file"></i>
Detail Pembayaran
</a>


<?php if($level === 'admin'): ?>
<a href="/spp_sekolah/petugas/index.php">
<i class="fa fa-user-shield"></i>
Data Petugas
</a>
<?php endif; ?>


<a href="/spp_sekolah/logout.php">
<i class="fa fa-right-from-bracket"></i>
Logout
</a>


</div>