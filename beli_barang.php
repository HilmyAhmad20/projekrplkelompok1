<?php
session_start();
include "connection.php";
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

$user = $_SESSION['username'];
if ($user) {
    $sql = "SELECT * from user where username='$user'";
    $query_user = $koneksi->query($sql);
    $data_user = $query_user->fetch_array();
}

// Mendapatkan daftar produk dari database
$sql_barang = "SELECT * FROM barang";
$query_barang = $koneksi->query($sql_barang);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Barang - SportsCenter</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
   <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f1f1f1;
            margin: 0;
        }
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            padding: 15px;
            color: #fff;
        }
        .sidebar .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
            border: 2px solid #fff;
        }
        .sidebar .profile h5 {
            margin-bottom: 5px;
        }
        .sidebar .profile p {
            margin-bottom: 10px;
            font-size: 14px;
            color: #ced4da;
        }
        .sidebar .menu a {
            color: #ced4da;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .sidebar .menu a:hover {
            background-color: #495057;
            color: #fff;
        }
        .sidebar .menu a.active {
            background-color: #007bff;
            color: #fff;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #2c2c2c; /* Ubah warna latar belakang konten menjadi abu-abu gelap */
            color: #ffffff; /* Ubah warna teks konten menjadi putih */
        }
        .alert {
            background-color: #28a745;
            color: #fff;
        }
        .table {
            background-color: #343a40; /* Ubah warna tabel agar lebih cocok dengan latar belakang hitam */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        .table td {
            color: #ffffff; /* Ubah warna teks di dalam tabel menjadi putih */
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="profile text-center">
        <img src="profile/admin.png" alt="Profile Image">
        <?php if ($user) { ?>
            <h5><?php echo $data_user['username']; ?></h5>
            <p><?php echo $data_user['level']; ?></p>
        <?php } else { ?>
            <h5>Guest</h5>
            <p>Level: Guest</p>
        <?php } ?>
    </div>
    <div class="menu">
        <a href="home.php"><i class="fas fa-user"></i> Profil</a>
        <a href="beli_barang.php" class="active"><i class="fas fa-shopping-basket"></i> Beli Barang</a>
        <a href="cari_barang.php"><i class="fas fa-search"></i> Cari Barang</a>
          <a href='riwayat_pembelian.php'><i class="fas fa-history"></i> Riwayat Pembelian</a> 
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<div class="content">
    <div class="header">
        <h1><i class="fas fa-basketball-ball"></i> SportsCenter <i class="fas fa-basketball-ball"></i></h1>
    </div>
    <div class="container mt-5">
        <h2 class="text-center text-white">Beli Barang</h2>
        <div class="row">
            <?php while ($produk = $query_barang->fetch_assoc()) { ?>
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <?php
                        // Ambil nama file gambar dari kolom 'gambar_barang'
                        $gambar_barang = $produk['gambar_barang'];
                        ?>
                        <img src="http://localhost/projekrpl/barang/<?php echo $gambar_barang; ?>" class="card-img-top" alt="<?php echo $produk['nama']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                            <p class="card-text">Harga: Rp <?php echo $produk['harga']; ?></p>
                            <p class="card-text">Stok: <?php echo $produk['stok']; ?></p>
                            <?php if ($user) { ?>
                                <a href="form_pembayaran.php?product_id=<?php echo $produk['id']; ?>" class="btn btn-primary">Beli Barang</a>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-primary" onclick="alert('Silakan login terlebih dahulu untuk membeli barang.');">Beli Barang</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS dan dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
