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
$sql = "SELECT * FROM barang WHERE id='$id'";
$query = $koneksi->query($sql);
$barang = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $sql = "UPDATE barang SET nama='$nama', harga='$harga', stok='$stok' WHERE id='$id'";
    if ($koneksi->query($sql) === TRUE) {
        header("Location: katalog_barang.php");
    } else {
        echo "Error updating record: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - SportsCenter</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            background-color: #333;
            color: #fff;
            border: 1px solid #555;
        }
        .form-control:focus {
            background-color: #444;
            border-color: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Barang</h1>
    <form method="post">
        <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="<?php echo $barang['nama']; ?>" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?php echo $barang['harga']; ?>" required>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="<?php echo $barang['stok']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="katalog_barang.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<!-- Bootstrap JS dan dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
