<?php

include 'service/database.php';
$register_message= "";

if(isset($_POST['register'])){
    $username= $_POST['nama'];
    $password= $_POST['password'];

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if($db->query($sql)){
        $register_message = "Daftar Akun Berhasil, Silahkan Login";
    }else{
        $register_message = "Daftar Akun Gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="stylesheet" href="assets/css/style3.css">
    <title>Register - Aplikasi Penilaian Rapor</title>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>REGISTER</h2>
    </div>
        <div class="form-group">
            <?php if(!empty($register_message)): ?>
                <p><?php echo $register_message; ?></p>
            <?php endif; ?>
            <form action="register.php" method="post" id="register-form">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" placeholder="Email" required name="nama">
                <label for="register-password">Password</label>
                <input type="password" id="register-password" placeholder="Password" required name="password">
                <button type="submit" name="register">Register</button>
            </form>
    <div class="form-footer">
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</div>  
</body>
</html>
