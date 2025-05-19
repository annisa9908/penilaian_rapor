<?php
session_start();
include "service/database.php";

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil data user dari DB
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun</title>
    <link rel="stylesheet" href="assets/css/akun.css">
</head>
<body>
<div class="back">
    <a href="dashboard.php">⮌ Back</a>
</div>
    <div class="container">
        <h1 class="page-title">Pengaturan Akun</h1>
        
        <div class="account-card">
            <div class="user-info">
                <div class="info-item">
                    <p class="info-label">Email</p>
                    <p class="info-value"><?= htmlspecialchars($user['username']) ?></p>
                </div>
                <!-- Tambahkan jabatan jika kolom tersebut ditambahkan ke tabel `users` -->
            </div>
            
            <div class="settings-options">
                <a href="ubah_email.php" class="settings-button">Ubah Nama Pengguna</a>
                <a href="ubah_password.php" class="settings-button">Ubah Kata Sandi</a>
            </div>
            
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>
</html>
