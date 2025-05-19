<?php
include "service/database.php";

$id = $_POST['id'];
$nilai = $_POST['nilai'];

mysqli_query($db, "UPDATE nilai_siswa SET nilai = '$nilai' WHERE id = $id");

header("Location: rekap_rapor.php");
exit;
?>
