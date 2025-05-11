<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../../koneksi/koneksi.php';

if (isset($_GET['id']) && $_GET['id'] == 'konfirmasi') {
    // Pastikan data dikirim via POST
    if (!isset($_POST['status']) || !isset($_POST['id_mobil'])) {
        die("Error: Data tidak lengkap.");
    }

    $status = $_POST['status'];
    $id_mobil = $_POST['id_mobil'];

    try {
        $sql2 = "UPDATE `mobil` SET `status`= ? WHERE id_mobil= ?";
        $stmt = $koneksi->prepare($sql2);
        $stmt->execute([$status, $id_mobil]);

        echo '<script>alert("Status mobil berhasil diubah");history.go(-1);</script>';
    } catch (PDOException $e) {
        die("Query gagal: " . $e->getMessage());
    }
} else {
    die("Error: Parameter tidak valid.");
}
?>
