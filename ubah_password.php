<?php
session_start();
include "service/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $result = $db->query("SELECT password FROM users WHERE id = $user_id");
    $user = $result->fetch_assoc();

    if ($user && $old_password === $user['password']) { // kamu bisa ubah ke password_verify jika pakai hash
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_password, $user_id);
        if ($stmt->execute()) {
            $message = "Password berhasil diubah.";
        } else {
            $message = "Gagal memperbarui password.";
        }
        $stmt->close();
    } else {
        $message = "Password lama salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
    <link rel="stylesheet" href="assets/css/ubah_password.css">
</head>
<body>
<div class="container">
    <h1>Ubah Password</h1>
    <form method="POST">
        <label>Password Lama</label><br>
        <input type="password" name="old_password" required><br><br>
        <label>Password Baru</label><br>
        <input type="password" name="new_password" required><br><br>
        <button type="submit">Simpan</button>
    </form>
    <p><?= $message ?></p>
    <a href="akun.php">← Kembali</a>
</div>
</body>
</html>
