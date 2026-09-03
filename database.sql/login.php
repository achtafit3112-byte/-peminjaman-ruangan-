<?php
session_start();
require_once "config/database.php";
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location:index.php"); exit; }
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$stmt = $conn->prepare("SELECT username, password FROM users WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
if ($user && $password === $user['password']) {
    $_SESSION['admin'] = $user['username'];
    header("Location: pages/dashboard.php");
    exit;
}
header("Location:index.php?error=" . urlencode("Username atau password salah."));
exit;
