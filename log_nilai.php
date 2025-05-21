<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Perubahan Nilai</title>
    <link rel="stylesheet" href="assets/css/style5.css">
</head>
<body>
<div class="back">
    <a href="dashboard.php">⮌ Back</a>
</div>
<div class="container">
    <h2>Log Perubahan Nilai</h2>
    <?php
    include "service/database.php";

    $sql = "SELECT * FROM log_nilai ORDER BY log_id ASC";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' cellspacing='0'>";
        echo "<tr><th>ID Log</th><th>Nama Siswa</th><th>Mata Pelajaran</th><th>Nilai Lama</th><th>Nilai Baru</th><th>Waktu</th><th>Aksi</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['log_id']}</td>";
            echo "<td>{$row['nama_siswa']}</td>";
            echo "<td>{$row['mata_pelajaran']}</td>";
            echo "<td>{$row['nilai_lama']}</td>";
            echo "<td>{$row['nilai_baru']}</td>";
            echo "<td>{$row['waktu_perubahan']}</td>";
            echo "<td>{$row['aksi']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Belum ada log perubahan nilai.</p>";
    }

    $db->close();
    ?>
</div>
</body>
</html>