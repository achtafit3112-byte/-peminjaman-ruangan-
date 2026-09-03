<?php
require_once "../includes/auth.php";
require_once "../config/database.php";
$title="Dashboard";
$jmlRuangan=$conn->query("SELECT COUNT(*) total FROM ruangan")->fetch_assoc()['total'];
$jmlPeminjaman=$conn->query("SELECT COUNT(*) total FROM peminjaman")->fetch_assoc()['total'];
$menunggu=$conn->query("SELECT COUNT(*) total FROM peminjaman WHERE status='Menunggu'")->fetch_assoc()['total'];
$disetujui=$conn->query("SELECT COUNT(*) total FROM peminjaman WHERE status='Disetujui'")->fetch_assoc()['total'];
include "../includes/header.php";
?>
<div class="hero p-4 mb-4">
    <h2 class="fw-bold">Selamat Datang di SIPERU 👋</h2>
    <p class="mb-0">Kelola data ruangan dan peminjaman ruangan dengan mudah.</p>
</div>
<div class="row g-4">
<?php
$cards=[
['Jumlah Ruangan',$jmlRuangan,'bi-door-open'],
['Total Peminjaman',$jmlPeminjaman,'bi-calendar-check'],
['Menunggu Persetujuan',$menunggu,'bi-hourglass-split'],
['Disetujui',$disetujui,'bi-check-circle']
];
foreach($cards as $c): ?>
<div class="col-md-3"><div class="card card-soft p-3 h-100">
<div class="text-muted"><?= $c[0] ?></div><h2 class="fw-bold"><?= $c[1] ?></h2>
<i class="bi <?= $c[2] ?> fs-3 text-primary"></i></div></div>
<?php endforeach; ?>
</div>
<div class="card card-soft p-4 mt-4">
<h5 class="fw-bold">Alur Sistem</h5>
<p class="mb-0">Data Ruangan → Pengajuan Peminjaman → Pemeriksaan Jadwal → Persetujuan → Laporan.</p>
</div>
<?php include "../includes/footer.php"; ?>
