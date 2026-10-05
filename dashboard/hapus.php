<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['admin'])) {
  header('location: ../login.php');
  exit();
}

/** @var mysqli $koneksi */
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil info file gambar untuk dihapus
    $stmt = mysqli_prepare($koneksi, "SELECT poto FROM tb_produk WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['poto'])) {
            $path = "../assets/img/" . $row['poto'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
    }

    $stmtDelete = mysqli_prepare($koneksi, "DELETE FROM tb_produk WHERE id = ?");
    mysqli_stmt_bind_param($stmtDelete, "i", $id);
    mysqli_stmt_execute($stmtDelete);
}

header("location: dasbor.php");
exit();
