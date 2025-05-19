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
    $new_email = $_POST['email'];

    if (filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $new_email, $user_id);
        if ($stmt->execute()) {
            $message = "Email berhasil diperbarui.";
        } else {
            $message = "Terjadi kesalahan.";
        }
        $stmt->close();
    } else {
        $message = "Email tidak valid.";
    }
}

$result = $db->query("SELECT username FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Email</title>
    <link rel="stylesheet" href="assets/css/ubah_email.css">
</head>
<body>
<div class="container">
    <h1>Ubah Email</h1>
    <form method="POST">
        <label>Email Baru</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['username']) ?>" required><br><br>
        <button type="submit">Simpan</button>
    </form>
    <p><?= $message ?></p>
    <a href="akun.php">← Kembali</a>
</div>
</body>
</html>
