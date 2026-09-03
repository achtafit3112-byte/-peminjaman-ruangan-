<?php
require_once "../includes/auth.php";
require_once "../config/database.php";
$title="Laporan Peminjaman";
$data=$conn->query("SELECT p.*,r.nama AS nama_ruangan FROM peminjaman p JOIN ruangan r ON p.ruangan_id=r.id ORDER BY p.tanggal DESC,p.waktu_mulai DESC");
include "../includes/header.php";
?>
<div class="d-flex justify-content-between align-items-center mb-3"><h3 class="fw-bold">Laporan Peminjaman</h3><button class="btn btn-outline-primary" onclick="window.print()">Cetak</button></div>
<div class="card card-soft p-4"><div class="table-responsive"><table class="table table-striped"><thead><tr><th>No</th><th>Peminjam</th><th>Ruangan</th><th>Kegiatan</th><th>Tanggal</th><th>Waktu</th><th>Status</th></tr></thead><tbody>
<?php $no=1; while($p=$data->fetch_assoc()): ?><tr><td><?= $no++ ?></td><td><?= htmlspecialchars($p['nama_peminjam']) ?></td><td><?= htmlspecialchars($p['nama_ruangan']) ?></td><td><?= htmlspecialchars($p['kegiatan']) ?></td><td><?= date('d-m-Y',strtotime($p['tanggal'])) ?></td><td><?= substr($p['waktu_mulai'],0,5) ?> - <?= substr($p['waktu_selesai'],0,5) ?></td><td><?= htmlspecialchars($p['status']) ?></td></tr><?php endwhile; ?>
</tbody></table></div></div>
<?php include "../includes/footer.php"; ?>
