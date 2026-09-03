<?php
require_once "../includes/auth.php";
require_once "../config/database.php";
$title="Data Ruangan";

if(isset($_POST['simpan'])){
    $nama=trim($_POST['nama']); $lokasi=trim($_POST['lokasi']); $kapasitas=(int)$_POST['kapasitas']; $fasilitas=trim($_POST['fasilitas']);
    $stmt=$conn->prepare("INSERT INTO ruangan(nama,lokasi,kapasitas,fasilitas) VALUES(?,?,?,?)");
    $stmt->bind_param("ssis",$nama,$lokasi,$kapasitas,$fasilitas); $stmt->execute();
    header("Location:ruangan.php?success=Data ruangan berhasil ditambahkan"); exit;
}
if(isset($_POST['update'])){
    $id=(int)$_POST['id']; $nama=trim($_POST['nama']); $lokasi=trim($_POST['lokasi']); $kapasitas=(int)$_POST['kapasitas']; $fasilitas=trim($_POST['fasilitas']);
    $stmt=$conn->prepare("UPDATE ruangan SET nama=?,lokasi=?,kapasitas=?,fasilitas=? WHERE id=?");
    $stmt->bind_param("ssisi",$nama,$lokasi,$kapasitas,$fasilitas,$id); $stmt->execute();
    header("Location:ruangan.php?success=Data ruangan berhasil diperbarui"); exit;
}
if(isset($_GET['hapus'])){
    $id=(int)$_GET['hapus']; $stmt=$conn->prepare("DELETE FROM ruangan WHERE id=?"); $stmt->bind_param("i",$id);
    if($stmt->execute()) $msg="Data ruangan berhasil dihapus"; else $msg="Ruangan tidak dapat dihapus karena sudah digunakan dalam peminjaman.";
    header("Location:ruangan.php?success=".urlencode($msg)); exit;
}
$edit=null;
if(isset($_GET['edit'])){ $id=(int)$_GET['edit']; $stmt=$conn->prepare("SELECT * FROM ruangan WHERE id=?"); $stmt->bind_param("i",$id); $stmt->execute(); $edit=$stmt->get_result()->fetch_assoc(); }
$data=$conn->query("SELECT * FROM ruangan ORDER BY id DESC");
include "../includes/header.php";
?>
<h3 class="fw-bold mb-3">Data Ruangan</h3>
<?php if(isset($_GET['success'])): ?><div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div><?php endif; ?>
<div class="card card-soft p-4 mb-4">
<h5><?= $edit?'Edit Ruangan':'Tambah Ruangan' ?></h5>
<form method="POST" class="row g-3">
<?php if($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif; ?>
<div class="col-md-4"><label class="form-label">Nama Ruangan</label><input name="nama" class="form-control" required value="<?= htmlspecialchars($edit['nama']??'') ?>" placeholder="Ruang Lab 1"></div>
<div class="col-md-3"><label class="form-label">Lokasi</label><input name="lokasi" class="form-control" required value="<?= htmlspecialchars($edit['lokasi']??'') ?>" placeholder="Gedung A Lantai 2"></div>
<div class="col-md-2"><label class="form-label">Kapasitas</label><input type="number" name="kapasitas" min="1" class="form-control" required value="<?= $edit['kapasitas']??'' ?>"></div>
<div class="col-md-3"><label class="form-label">Fasilitas</label><input name="fasilitas" class="form-control" value="<?= htmlspecialchars($edit['fasilitas']??'') ?>" placeholder="LCD, AC, Wi-Fi"></div>
<div class="col-12"><button name="<?= $edit?'update':'simpan' ?>" class="btn btn-primary"><?= $edit?'Update':'Simpan' ?></button><?php if($edit): ?><a href="ruangan.php" class="btn btn-secondary ms-2">Batal</a><?php endif; ?></div>
</form></div>
<div class="card card-soft p-4"><div class="table-responsive"><table class="table table-hover align-middle">
<thead><tr><th>No</th><th>Ruangan</th><th>Lokasi</th><th>Kapasitas</th><th>Fasilitas</th><th>Aksi</th></tr></thead><tbody>
<?php $no=1; while($r=$data->fetch_assoc()): ?><tr><td><?= $no++ ?></td><td><?= htmlspecialchars($r['nama']) ?></td><td><?= htmlspecialchars($r['lokasi']) ?></td><td><?= $r['kapasitas'] ?> orang</td><td><?= htmlspecialchars($r['fasilitas']) ?></td><td><a class="btn btn-sm btn-warning" href="?edit=<?= $r['id'] ?>">Edit</a> <a class="btn btn-sm btn-danger" href="?hapus=<?= $r['id'] ?>" onclick="return confirm('Hapus ruangan ini?')">Hapus</a></td></tr><?php endwhile; ?>
</tbody></table></div></div>
<?php include "../includes/footer.php"; ?>
