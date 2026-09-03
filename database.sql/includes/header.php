<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Peminjaman Ruangan') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="bi bi-building me-2"></i>SIPERU
        </a>
        <div class="text-white">
            <i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($_SESSION['admin'] ?? 'Admin') ?>
            <a href="../logout.php" class="btn btn-light btn-sm ms-3">Logout</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-2 sidebar p-3">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a href="ruangan.php" class="list-group-item list-group-item-action"><i class="bi bi-door-open me-2"></i>Data Ruangan</a>
                <a href="peminjaman.php" class="list-group-item list-group-item-action"><i class="bi bi-calendar-check me-2"></i>Peminjaman</a>
                <a href="laporan.php" class="list-group-item list-group-item-action"><i class="bi bi-file-earmark-text me-2"></i>Laporan</a>
            </div>
        </aside>
        <main class="col-md-10 p-4">
