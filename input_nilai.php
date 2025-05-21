<?php
include "service/database.php";

$input_message = "";
$success = false;

if (isset($_POST['simpan'])) {
    $nama_siswa = $_POST['nama'];
    $mata_pelajaran = $_POST['mata_pelajaran'];
    $nilai = $_POST['nilai'];

    // Cek apakah mata pelajaran ini sudah ada untuk siswa yang sama
    $sql_check = "SELECT * FROM nilai_siswa WHERE nama_siswa = ? AND mata_pelajaran = ?";
    $stmt = $db->prepare($sql_check);
    $stmt->bind_param("ss", $nama_siswa, $mata_pelajaran);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $input_message = "Error: Nilai untuk mata pelajaran ini sudah ada untuk siswa ini, silahkan masukkan nilai yang lain.";
    } else {
        // Jika belum ada, masukkan nilai baru
        $sql_insert = "INSERT INTO nilai_siswa (nama_siswa, mata_pelajaran, nilai) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql_insert);
        $stmt->bind_param("ssi", $nama_siswa, $mata_pelajaran, $nilai);
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            $input_message = "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}
// Tutup koneksi
$db->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai</title>
    <link rel="stylesheet" href="assets/css/style4.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="back">
        <a href="dashboard.php">⮌ Back</a>
    </div>
    <div class="container">
        <h2>Input Nilai Siswa</h2>
        <form action="input_nilai.php" method="POST">
            <?php if (!empty($input_message)): ?>
                <p style="color: red;"><?php echo $input_message; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="nama">Nama Siswa</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="mata_pelajaran">Mata Pelajaran</label>
                <select id="mata_pelajaran" name="mata_pelajaran" required>
                    <option value="Matematika">Matematika</option>
                    <option value="IPA">IPA</option>
                    <option value="IPS">IPS</option>
                    <option value="PJOK">PJOK</option>
                    <option value="PKN">PKN</option>
                    <option value="Bahasa Inggris">Bahasa Inggris</option>
                    <option value="Bahasa Jepang">Bahasa Jepang</option>
                    <option value="Bahasa Sunda">Seni Budaya</option>
                    <option value="Pendidikan Agama">Pendidikan Agama</option>
                    <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    <option value="Sejarah">Sejarah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nilai">Nilai</label>
                <input type="number" id="nilai" name="nilai" required>
            </div>
            <button type="submit" name="simpan">Simpan Nilai</button>
        </form>
    </div>

    <!-- JavaScript untuk SweetAlert -->
    <?php if ($success): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Nilai berhasil disimpan!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'rekap_rapor.php';
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>