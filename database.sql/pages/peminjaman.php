<?php
require_once "../includes/auth.php";
require_once "../config/database.php";
$title="Peminjaman Ruangan";

if(isset($_POST['ajukan'])){
    $ruangan_id=(int)$_POST['ruangan_id']; $nama_peminjam=trim($_POST['nama_peminjam']); $kegiatan=trim($_POST['kegiatan']);
    $tanggal=$_POST['tanggal']; $waktu_mulai=$_POST['waktu_mulai']; $waktu_selesai=$_POST['waktu_selesai'];
    $cek=$conn->prepare("SELECT COUNT(*) total FROM peminjaman WHERE ruangan_id=? AND tanggal=? AND status IN('Menunggu','Disetujui') AND waktu_mulai < ? AND waktu_selesai > ?");
    $cek->bind_param("isss",$ruangan_id,$tanggal,$waktu_selesai,$waktu_mulai); $cek->execute();
    $bentrok=$cek->get_result()->fetch_assoc()['total'];
    if($bentrok>0){ $error="Jadwal ruangan bentrok dengan peminjaman yang masih aktif."; }
    elseif($waktu_selesai <= $waktu_mulai){ $error="Waktu selesai harus lebih besar dari waktu mulai."; }
    else {
        $stmt=$conn->prepare("INSERT INTO peminjaman(ruangan_id,nama_peminjam,kegiatan,tanggal,waktu_mulai,waktu_selesai,status) VALUES(?,?,?,?,?,?, 'Menunggu')");
        $stmt->bind_param("isssss",$ruangan_id,$nama_peminjam,$kegiatan,$tanggal,$waktu_mulai,$waktu_selesai); $stmt->execute();
        header("Location:peminjaman.php?success=Pengajuan berhasil dibuat"); exit;
    }
}
if(isset($_GET['status'],$_GET['id']) && in_array($_GET['status'],['Disetujui','Ditolak'])){
    $id=(int)$_GET['id']; $status=$_GET['status']; $stmt=$conn->prepare("UPDATE peminjaman SET status=? WHERE id=?"); $stmt->bind_param("si",$status,$id); $stmt->execute();
    header("Location:peminjaman.php?success=Status peminjaman diperbarui"); exit;
}
$ruangan=$conn->query("SELECT * FROM ruangan ORDER BY nama");
$data=$conn->query("SELECT p.*,r.nama AS nama_ruangan FROM peminjaman p JOIN ruangan r ON p.ruangan_id=r.id ORDER BY p.tanggal DESC,p.waktu_mulai DESC");
include "../includes/header.php";
?>
<h3 class="fw-bold mb-3">Peminjaman Ruangan</h3>
<?php if(isset($_GET['success'])): ?><div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div><?php endif; ?>
<?php if(isset($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<div class="card card-soft p-4 mb-4"><h5 class="fw-bold">Form Pengajuan</h5>
<form method="POST" class="row g-3">
<div class="col-md-4"><label class="form-label">Ruangan</label><select name="ruangan_id" class="form-select" required><option value="">-- Pilih Ruangan --</option><?php while($r=$ruangan->fetch_assoc()): ?><option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nama']) ?> - <?= htmlspecialchars($r['lokasi']) ?></option><?php endwhile; ?></select></div>
<div class="col-md-4"><label class="form-label">Nama Peminjam</label><input name="nama_peminjam" class="form-control" required></div>
<div class="col-md-4"><label class="form-label">Kegiatan</label><input name="kegiatan" class="form-control" required placeholder="Rapat / Seminar / Kuliah"></div>
<div class="col-md-4"><label class="form-label">Tanggal</label><input type="date" name="tanggal" class="form-control" required></div>
<div class="col-md-3"><label class="form-label">Waktu Mulai</label><input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control" required onchange="hitungDurasi()"></div>
<div class="col-md-3"><label class="form-label">Waktu Selesai</label><input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control" required onchange="hitungDurasi()"></div>
<div class="col-md-2"><label class="form-label">Durasi</label><input id="durasi" class="form-control" readonly></div>
<div class="col-12"><button name="ajukan" class="btn btn-primary"><i class="bi bi-send me-1"></i>Ajukan Peminjaman</button></div>
</form></div>
<div class="card card-soft p-4"><h5 class="fw-bold">Daftar Peminjaman</h5><div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>No</th><th>Peminjam</th><th>Ruangan</th><th>Kegiatan</th><th>Jadwal</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php $no=1; while($p=$data->fetch_assoc()): ?>
<tr><td><?= $no++ ?></td><td><?= htmlspecialchars($p['nama_peminjam']) ?></td><td><?= htmlspecialchars($p['nama_ruangan']) ?></td><td><?= htmlspecialchars($p['kegiatan']) ?></td><td><?= date('d-m-Y',strtotime($p['tanggal'])) ?><br><?= substr($p['waktu_mulai'],0,5) ?> - <?= substr($p['waktu_selesai'],0,5) ?></td>
<td><span class="badge <?= $p['status']=='Disetujui'?'bg-success':($p['status']=='Ditolak'?'bg-danger':'bg-warning text-dark') ?>"><?= $p['status'] ?></span></td>
<td><?php if($p['status']=='Menunggu'): ?><a class="btn btn-sm btn-success" href="?id=<?= $p['id'] ?>&status=Disetujui">Setujui</a> <a class="btn btn-sm btn-danger" href="?id=<?= $p['id'] ?>&status=Ditolak">Tolak</a><?php else: ?>-<?php endif; ?></td></tr>
<?php endwhile; ?></tbody></table></div></div>
<?php include "../includes/footer.php"; ?>
