<?php
session_start();
include "service/database.php";
$login_message= "";

if(isset($_POST['login'])){
    $username = $_POST['nama'];  // email
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $db->query($sql);

    if($result->num_rows > 0){
        $data = $result->fetch_assoc();
        $_SESSION['user_id'] = $data['id'];
        header("location: dashboard.php");
        exit;
    } else {
        $login_message = "Email atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="assets/css/style2.css">
    <title>Login - Aplikasi Penilaian Rapor</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>LOGIN</h2>
        </div>
        <div class="form-group">
            <?php if (!empty($login_message)): ?>
                <p style="color: red;"><?php echo $login_message; ?></p>
            <?php endif; ?>
            <form action="login.php" method="post">
                <label for="nama">Email</label>
                <input type="email" id="nama" placeholder="Masukkan Email" name="nama" required>
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Masukkan Password" name="password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <div class="alt-action">
                <a href="register.php">Belum punya akun? Register</a>
            </div>
        </div>
    </div>
</body>
</html>
