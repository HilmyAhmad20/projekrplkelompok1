<?php
session_start();
include "connection.php";

// Cek apakah user adalah admin
if (!isset($_SESSION['username'])) {
    die("Anda belum login");
}

$user = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username='$user'";
$query_user = $koneksi->query($sql);
$data_user = $query_user->fetch_array();

// Mendapatkan daftar pesanan dari database
$sql = "SELECT p.id, p.username, b.nama AS nama_produk, p.jumlah, p.tanggal_pembelian, u.alamat, p.status
        FROM pembelian p
        JOIN barang b ON p.id_produk = b.id
        JOIN user u ON p.username = u.username
        ORDER BY p.tanggal_pembelian DESC";
$query = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Pesanan - SportsCenter</title>
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
        <h5><?php echo $data_user['username']; ?></h5>
        <p><?php echo $data_user['level']; ?></p>
    </div>
    <div class="menu">
        <a href="home.php"><i class="fas fa-user"></i> Profil</a>
        <a href='tambah_produk.php'><i class="fas fa-plus"></i> Tambah Barang Baru</a>
        <a href='katalog_barang.php'><i class="fas fa-th-list"></i> Katalog Barang</a>
        <a href='lihat_pesanan.php' class="active"><i class="fas fa-shopping-cart"></i> Lihat Pesanan</a>
        <a href='riwayat_pembelian.php'><i class="fas fa-history"></i> Riwayat Pembelian</a> 
        <a href='logout.php'><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<div class="content">
    <div class="header">
        <h1><i class="fas fa-basketball-ball"></i> SportsCenter <i class="fas fa-basketball-ball"></i></h1>
    </div>
    <div class="container mt-5">
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success" role="alert">
                Pengiriman berhasil!
            </div>
        <?php endif; ?>
        <h1 class="text-center">Daftar Pesanan</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pembelian</th>
                    <th>Alamat Pengiriman</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $query->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $order['id']; ?></td>
                        <td><?php echo $order['username']; ?></td>
                        <td><?php echo $order['nama_produk']; ?></td>
                        <td><?php echo $order['jumlah']; ?></td>
                        <td><?php echo $order['tanggal_pembelian']; ?></td>
                        <td><?php echo $order['alamat']; ?></td>
                        <td><?php echo $order['status'] == 'terkirim' ? 'Terkirim' : 'Belum Terkirim'; ?></td>
                        <td>
                            <?php if ($order['status'] != 'terkirim'): ?>
                                <form action="kirim_barang.php" method="post">
                                    <input type="hidden" name="id_pesanan" value="<?php echo $order['id']; ?>">
                                    <input type="hidden" name="username" value="<?php echo $order['username']; ?>">
                                    <input type="hidden" name="alamat" value="<?php echo $order['alamat']; ?>">
                                    <input type="hidden" name="nama_produk" value="<?php echo $order['nama_produk']; ?>">
                                    <input type="hidden" name="jumlah" value="<?php echo $order['jumlah']; ?>">
                                    <button type="submit" class="btn btn-primary">Kirim Barang</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-success" disabled>Terkirim</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Bootstrap JS dan dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
