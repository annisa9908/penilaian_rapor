<?php
include "service/database.php";
$id = $_GET['id'];
$result = mysqli_query($db, "SELECT * FROM nilai_siswa WHERE id = $id");
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Nilai</title>
    <link rel="stylesheet" href="assets/css/style5.css">
</head>
<body>
<div class="container">
    <h2>Edit Nilai untuk <?= $data['nama_siswa'] ?></h2>
    <form action="proses_edit.php" method="post">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <p><strong>Mata Pelajaran:</strong> <?= $data['mata_pelajaran'] ?></p>
        <label for="nilai">Nilai:</label>
        <input type="number" name="nilai" id="nilai" value="<?= $data['nilai'] ?>" required><br><br>
        <input type="submit" value="Simpan" class="btn-edit">
        <a href="rekap_rapor.php" class="btn-hapus">Batal</a>
    </form>
</div>
</body>
</html>
