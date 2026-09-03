<?php
session_start();
if (isset($_SESSION['admin'])) {
    header("Location: pages/dashboard.php");
    exit;
}
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - SIPERU</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page d-flex align-items-center justify-content-center p-3">
<div class="card login-card shadow-lg p-4">
    <div class="text-center mb-4">
        <div class="display-4 text-primary"><i class="bi bi-building"></i></div>
        <h2 class="fw-bold">SIPERU</h2>
        <p class="text-muted">Sistem Informasi Peminjaman Ruangan</p>
    </div>
    <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form action="login.php" method="POST">
        <div class="mb-3"><label class="form-label">Username</label><input name="username" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
        <button class="btn btn-primary w-100">Login</button>
    </form>
    <div class="text-center mt-3 small text-muted">Demo: <b>admin</b> / <b>admin123</b></div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
