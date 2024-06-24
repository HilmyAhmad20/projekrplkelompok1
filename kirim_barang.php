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

    // Tampilkan informasi pesanan dan formulir konfirmasi pengiriman
    echo "
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Kirim Barang</title>
        <!-- Bootstrap CSS -->
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                background-color: #333333; /* Hitam muda */
                color: #ffffff; /* Warna teks putih */
            }
            .card {
                background-color: #444444; /* Warna kartu lebih terang dari latar belakang */
                color: #ffffff; /* Warna teks kartu tetap putih */
            }
            .btn-secondary {
                background-color: #555555; /* Warna tombol sekunder lebih terang */
                border-color: #555555;
            }
            .btn-secondary:hover {
                background-color: #666666; /* Warna tombol sekunder saat hover lebih terang lagi */
                border-color: #666666;
            }
            .btn-success {
                background-color: #28a745; /* Warna tombol sukses tetap hijau */
                border-color: #28a745;
            }
            .btn-success:hover {
                background-color: #218838; /* Warna tombol sukses saat hover */
                border-color: #1e7e34;
            }
        </style>
    </head>
    <body>
    <div class='container mt-5'>
        <h1 class='text-center'>Kirim Barang</h1>
        <div class='card'>
            <div class='card-body'>
                <h5 class='card-title'>Detail Pesanan</h5>
                <p><strong>Nama Pembeli:</strong> $username</p>
                <p><strong>Alamat Pengiriman:</strong> $alamat</p>
                <p><strong>Nama Produk:</strong> $nama_produk</p>
                <p><strong>Jumlah:</strong> $jumlah</p>
                <form action='proses_kirim_barang.php' method='post'>
                    <input type='hidden' name='id_pesanan' value='$id_pesanan'>
                    <input type='hidden' name='username' value='$username'>
                    <input type='hidden' name='alamat' value='$alamat'>
                    <input type='hidden' name='nama_produk' value='$nama_produk'>
                    <input type='hidden' name='jumlah' value='$jumlah'>
                    <button type='submit' class='btn btn-success'>Kirim Barang</button>
                    <a href='lihat_pesanan.php' class='btn btn-secondary'>Kembali</a>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS dan dependencies -->
    <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js'></script>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
    </body>
    </html>";
}
?>
