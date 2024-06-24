<?php
session_start();
include "connection.php";

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    die("Anda belum login");
}

// Periksa apakah ID barang sudah diterima
if (!isset($_GET['id'])) {
    die("ID barang tidak ada.");
}

$id = $_GET['id'];
$sql = "DELETE FROM barang WHERE id='$id'";

if ($koneksi->query($sql) === TRUE) {
    header("Location: katalog_barang.php");
} else {
    echo "Error deleting record: " . $koneksi->error;
}
?>
