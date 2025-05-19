<?php
include "service/database.php";
$id = $_GET['id'];

mysqli_query($db, "DELETE FROM nilai_siswa WHERE id = $id");

header("Location: rekap_rapor.php");
exit;
?>
