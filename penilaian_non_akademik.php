<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Non Akademik</title>
    <link rel="stylesheet" href="assets/css/style6.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
<div class="back">
    <a href="dashboard.php">⮌ Back</a>
</div>
<div class="container">
    <h2><i class="fas fa-medal"></i> Penilaian Non Akademik Siswa</h2>
    <?php
    include "service/database.php";

    function pilihan_nilai($selected = '') {
        $options = ['A', 'B', 'C', 'D'];
        $html = '';
        foreach ($options as $opt) {
            $selected_attr = ($selected == $opt) ? 'selected' : '';
            $html .= "<option value='$opt' $selected_attr>$opt</option>";
        }
        return $html;
    }

    if (isset($_POST['submit'])) {
        $nama_siswa = $_POST['nama_siswa'];
        $aspek = $_POST['aspek'];
        $nilai = $_POST['nilai'];
        $catatan = $_POST['catatan'];

        $check_sql = "SELECT id FROM penilaian_non_akademik WHERE nama_siswa = ? AND aspek = ?";
        $check_stmt = $db->prepare($check_sql);
        $check_stmt->bind_param("ss", $nama_siswa, $aspek);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $row = $check_result->fetch_assoc();
            $id = $row['id'];
            $update_sql = "UPDATE penilaian_non_akademik SET nilai = ?, catatan = ? WHERE id = ?";
            $update_stmt = $db->prepare($update_sql);
            $update_stmt->bind_param("ssi", $nilai, $catatan, $id);
            
            if ($update_stmt->execute()) {
                echo "<div class='success-msg'>Nilai non akademik berhasil diperbarui!</div>";
            } else {
                echo "<div class='error-msg'>Gagal memperbarui nilai.</div>";
            }
            $update_stmt->close();
        } else {
            $insert_sql = "INSERT INTO penilaian_non_akademik (nama_siswa, aspek, nilai, catatan) VALUES (?, ?, ?, ?)";
            $insert_stmt = $db->prepare($insert_sql);
            $insert_stmt->bind_param("ssss", $nama_siswa, $aspek, $nilai, $catatan);
            
            if ($insert_stmt->execute()) {
                echo "<div class='success-msg'>Nilai non akademik berhasil disimpan!</div>";
            } else {
                echo "<div class='error-msg'>Gagal menyimpan nilai.</div>";
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }

    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $hapus_sql = "DELETE FROM penilaian_non_akademik WHERE id = ?";
        $hapus_stmt = $db->prepare($hapus_sql);
        $hapus_stmt->bind_param("i", $id);
        
        if ($hapus_stmt->execute()) {
            echo "<div class='success-msg'>Data berhasil dihapus!</div>";
        } else {
            echo "<div class='error-msg'>Gagal menghapus data.</div>";
        }
        $hapus_stmt->close();
    }

    if (isset($_GET['nama'])) {
        $nama_siswa = $_GET['nama'];
        echo "<h3>Penilaian Non Akademik: <strong>$nama_siswa</strong></h3>";

        ?>
        <div class="form-container">
            <h4>Tambah/Edit Penilaian Non Akademik</h4>
            <form method="post" action="">
                <input type="hidden" name="nama_siswa" value="<?php echo $nama_siswa; ?>">
                
                <div class="form-group">
                    <label for="aspek">Aspek Penilaian:</label>
                    <select name="aspek" id="aspek" required>
                        <option value="">Pilih Aspek</option>
                        <option value="Kedisiplinan">Kedisiplinan</option>
                        <option value="Kerjasama">Kerjasama</option>
                        <option value="Keaktifan">Keaktifan</option>
                        <option value="Tanggung Jawab">Tanggung Jawab</option>
                        <option value="Sopan Santun">Sopan Santun</option>
                        <option value="Kreativitas">Kreativitas</option>
                        <option value="Kepemimpinan">Kepemimpinan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nilai">Nilai:</label>
                    <select name="nilai" id="nilai" required>
                        <option value="">Pilih Nilai</option>
                        <?php echo pilihan_nilai(); ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="catatan">Catatan/Deskripsi:</label>
                    <textarea name="catatan" id="catatan" rows="3"></textarea>
                </div>
                
                <div class="form-action">
                    <button type="submit" name="submit" class="btn-submit">Simpan Nilai</button>
                </div>
            </form>
        </div>

        <?php
        $sql_non_akademik = "SELECT id, aspek, nilai, catatan FROM penilaian_non_akademik WHERE nama_siswa = ? ORDER BY aspek";
        $stmt = $db->prepare($sql_non_akademik);
        $stmt->bind_param("s", $nama_siswa);
        $stmt->execute();
        $result_non_akademik = $stmt->get_result();

        if ($result_non_akademik->num_rows > 0) {
            echo "<h4>Data Penilaian Non Akademik</h4>";
            echo "<table border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr><th>Aspek</th><th>Nilai</th><th>Catatan/Deskripsi</th><th>Aksi</th></tr>";
            
            while ($row = $result_non_akademik->fetch_assoc()) {
                $id = $row['id'];
                echo "<tr>";
                echo "<td>{$row['aspek']}</td>";
                echo "<td>{$row['nilai']}</td>";
                echo "<td>{$row['catatan']}</td>";
                echo "<td>
                    <a href='penilaian_non_akademik.php?nama=" . urlencode($nama_siswa) . "&edit=$id' class='btn-edit'>Edit</a>
                    <a href='penilaian_non_akademik.php?nama=" . urlencode($nama_siswa) . "&hapus=$id' class='btn-hapus' onclick='return confirm(\"Hapus penilaian ini?\")'>Hapus</a>
                </td>";
                echo "</tr>";
            }

            echo "</table><br>";
        } else {
            echo "<p>Belum ada data penilaian non akademik untuk siswa ini.</p>";
        }
        $stmt->close();
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_sql = "SELECT aspek, nilai, catatan FROM penilaian_non_akademik WHERE id = ?";
            $edit_stmt = $db->prepare($edit_sql);
            $edit_stmt->bind_param("i", $edit_id);
            $edit_stmt->execute();
            $edit_result = $edit_stmt->get_result();
            
            if ($edit_result->num_rows > 0) {
                $edit_data = $edit_result->fetch_assoc();
                ?>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    document.getElementById('aspek').value = '<?php echo $edit_data['aspek']; ?>';
                    document.getElementById('nilai').value = '<?php echo $edit_data['nilai']; ?>';
                    document.getElementById('catatan').value = '<?php echo $edit_data['catatan']; ?>';
                });
                </script>
                <?php
            }
            $edit_stmt->close();
        }

        echo "<a href='penilaian_non_akademik.php' class='btn-back'>← Kembali ke daftar siswa</a><br><br>";
    } else {
        $sql_siswa = "SELECT DISTINCT nama_siswa FROM nilai_siswa ORDER BY nama_siswa";
        $result_siswa = $db->query($sql_siswa);

        if ($result_siswa->num_rows > 0) {
            echo "<table border='1' cellpadding='10' cellspacing='0'>";
            echo "<tr><th>Nama Siswa</th><th>Aksi</th></tr>";
            while ($row = $result_siswa->fetch_assoc()) {
                $nama = $row['nama_siswa'];
                echo "<tr>";
                echo "<td>$nama</td>";
                echo "<td style='text-align: right;'><a href='penilaian_non_akademik.php?nama=" . urlencode($nama) . "' class='btn-detail'>Input Penilaian</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Belum ada data siswa. Tambahkan siswa terlebih dahulu.</p>";
        }
    }

    $db->close();
    ?>
</div>

<div class="keterangan">
    <h3><i class="fas fa-info-circle"></i> Keterangan Nilai:</h3>
    <ul>
        <li><strong>A</strong> : Sangat Baik</li>
        <li><strong>B</strong> : Baik</li>
        <li><strong>C</strong> : Cukup</li>
        <li><strong>D</strong> : Perlu Bimbingan</li>
    </ul>
</div>
</body>
</html>