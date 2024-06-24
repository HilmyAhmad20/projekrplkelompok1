<?php
session_start();
include "connection.php";

// Cek apakah user adalah admin
if (!isset($_SESSION['username'])) {
    die("Anda belum login");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pesanan = $_POST['id_pesanan'];
    $username = $_POST['username'];
    $alamat = $_POST['alamat'];
    $nama_produk = $_POST['nama_produk'];
    $jumlah = $_POST['jumlah'];

    // Proses pengiriman barang (misalnya, update status pengiriman)
    $query_update = "UPDATE pembelian SET status = 'terkirim' WHERE id = $id_pesanan";
    $result_update = $koneksi->query($query_update);

    if ($result_update) {
        // Redirect kembali ke halaman lihat_pesanan.php setelah sukses update
        header("Location: lihat_pesanan.php?status=success");
        exit();
    } else {
        echo "Gagal mengupdate status pesanan.";
    }
}

    echo "
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Konfirmasi Pengiriman Barang</title>
        <!-- Bootstrap CSS -->
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
    <div class='container mt-5'>
        <div class='alert alert-success' role='alert'>
            <h4 class='alert-heading'>Pengiriman Terkonfirmasi!</h4>
            <p>Barang akan segera dikirim oleh bagian logistik ke alamat yang bersangkutan.</p>
            <hr>
            <p class='mb-0'>ID Pesanan: $id_pesanan</p>
            <p class='mb-0'>Nama Pembeli: $username</p>
            <p class='mb-0'>Alamat Pengiriman: $alamat</p>
            <p class='mb-0'>Nama Produk: $nama_produk</p>
            <p class='mb-0'>Jumlah: $jumlah</p>
        </div>
        <a href='lihat_pesanan.php' class='btn btn-secondary'>Kembali</a>
    </div>
    <!-- Bootstrap JS dan dependencies -->
    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
    </body>
    </html>";
?>
