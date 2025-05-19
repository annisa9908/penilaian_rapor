<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Rapor</title>
    <link rel="stylesheet" href="assets/css/style5.css">
</head>
<body>
<div class="back">
    <a href="dashboard.php">⮌ Back</a>
</div>
<div class="container">
    <h2>Rekap Nilai Siswa</h2>
    <?php
    include "service/database.php";

    // Jika ada parameter nama di URL, tampilkan detail
    if (isset($_GET['nama'])) {
        $nama_siswa = $_GET['nama'];
        echo "<h3>Detail Nilai: <strong>$nama_siswa</strong></h3>";

        $sql_nilai = "SELECT id, mata_pelajaran, nilai FROM nilai_siswa WHERE nama_siswa = ?";
        $stmt = $db->prepare($sql_nilai);
        $stmt->bind_param("s", $nama_siswa);
        $stmt->execute();
        $result_nilai = $stmt->get_result();

        if ($result_nilai->num_rows > 0) {
            echo "<table border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr><th>Mata Pelajaran</th><th>Nilai</th><th>Aksi</th></tr>";
            
            $total_nilai = 0;
            $jumlah_mapel = 0;

            while ($row = $result_nilai->fetch_assoc()) {
                $id = $row['id'];
                echo "<tr>";
                echo "<td>{$row['mata_pelajaran']}</td>";
                echo "<td>{$row['nilai']}</td>";
                echo "<td>
                    <a href='edit_nilai.php?id=$id' class='btn-edit'>Edit</a>
                    <a href='hapus_nilai.php?id=$id' class='btn-hapus' onclick='return confirm(\"Hapus nilai ini?\")'>Hapus</a>
                </td>";
                echo "</tr>";
                $total_nilai += $row['nilai'];
                $jumlah_mapel++;
            }

            $rata_rata = $jumlah_mapel > 0 ? $total_nilai / $jumlah_mapel : 0;
            echo "<tr><td><strong>Rata-rata</strong></td><td colspan='2'><strong>" . number_format($rata_rata, 2) . "</strong></td></tr>";
            echo "<tr><td><strong>Total Nilai</strong></td><td colspan='2'><strong>$total_nilai</strong></td></tr>";
            echo "</table><br>";
        } else {
            echo "<p>Tidak ada data nilai untuk siswa ini.</p>";
        }

        echo "<a href='rekap_rapor.php' class='btn-back'>← Kembali ke daftar siswa</a><br><br>";
    } else {
        // Tampilkan daftar nama siswa
        $sql_siswa = "SELECT DISTINCT nama_siswa FROM nilai_siswa ORDER BY nama_siswa";
        $result_siswa = $db->query($sql_siswa);

        if ($result_siswa->num_rows > 0) {
            echo "<table border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr><th>Nama Siswa</th><th>Aksi</th></tr>";
            while ($row = $result_siswa->fetch_assoc()) {
                $nama = $row['nama_siswa'];
                echo "<tr>";
                echo "<td>$nama</td>";
                echo "<td><a href='rekap_rapor.php?nama=" . urlencode($nama) . "' class='btn-detail'><b>Lihat Detail</b></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Belum ada data siswa.</p>";
        }
    }

    $db->close();
    ?>
</div>
</body>
</html>
