<?php
session_start();
include "connection.php";

// Pastikan pengguna telah login
if (!isset($_SESSION['username'])) {
    die("Anda harus login untuk membeli barang.");
}

// Mendapatkan ID produk dari parameter URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    
    // Mendapatkan detail produk dari database
    $sql = "SELECT * FROM barang WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();
    
    // Mendapatkan saldo pengguna dari database
    $username = $_SESSION['username'];
    $sql = "SELECT saldo FROM user WHERE username = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $saldo = $user['saldo'];
} else {
    die("ID produk tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40; /* Warna latar belakang hitam */
            color: #ffffff; /* Warna teks putih */
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background-color: #495057; /* Warna latar belakang container */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.3); /* Efek bayangan untuk kontainer */
        }
        .form-group label {
            font-weight: bold;
            color: #ffffff; /* Warna teks label putih */
        }
        .form-control {
            background-color: #343a40; /* Warna latar belakang input */
            color: #ffffff; /* Warna teks input putih */
            border-color: #6c757d; /* Warna border input */
        }
        .form-control:disabled {
            background-color: #495057; /* Warna latar belakang input disabled */
        }
        .form-group label, .form-control {
            color: #ffffff; /* Warna teks label dan input putih */
        }
        .form-control::placeholder {
            color: #ced4da; /* Warna placeholder input */
        }
        .btn-primary {
            background-color: #007bff; /* Warna background tombol */
            border-color: #007bff; /* Warna border tombol */
        }
        .btn-primary:hover {
            background-color: #0056b3; /* Warna background tombol saat di-hover */
            border-color: #0056b3; /* Warna border tombol saat di-hover */
        }
        /* Menyesuaikan warna background dan teks untuk input saldo */
        .form-group.saldo label {
            color: #ffffff; /* Warna teks label putih */
        }
        .form-group.saldo .form-control {
            background-color: #343a40; /* Warna latar belakang input hitam */
            color: #ffffff; /* Warna teks input putih */
            border-color: #6c757d; /* Warna border input */
        }
        /* Menyesuaikan warna background dan teks untuk input nama produk */
        .form-group.nama-produk label {
            color: #ffffff; /* Warna teks label putih */
        }
        .form-group.nama-produk .form-control {
            background-color: #343a40; /* Warna latar belakang input */
            color: #ffffff; /* Warna teks input putih */
            border-color: #6c757d; /* Warna border input */
        }
        /* Menyesuaikan warna background dan teks untuk input harga */
        .form-group.harga label {
            color: #ffffff; /* Warna teks label putih */
        }
        .form-group.harga .form-control {
            background-color: #343a40; /* Warna latar belakang input */
            color: #ffffff; /* Warna teks input putih */
            border-color: #6c757d; /* Warna border input */
        }
        .btn-back {
            background-color: #dc3545; /* Warna background tombol kembali */
            color: #ffffff; /* Warna teks tombol kembali putih */
            border-color: #dc3545; /* Warna border tombol kembali */
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
            transition: background-color 0.3s ease; /* Transisi warna latar belakang saat di-hover */
        }
        .btn-back:hover {
            background-color: #c82333; /* Warna background tombol kembali saat di-hover */
            border-color: #bd2130; /* Warna border tombol kembali saat di-hover */
        }
        /* Penyesuaian agar tombol "Kembali" memiliki panjang yang sama */
        .btn-back {
            width: 100%; /* Panjang tombol 100% dari container */
            text-align: center; /* Posisi teks tombol ke tengah */
            display: block; /* Menjadikan tombol sebagai blok */
            margin-top: 20px; /* Jarak antara tombol "Kembali" dengan tombol "Lanjutkan ke Pembayaran" */
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Form Pembayaran</h1>
    <form action="aksi_beli.php" method="post">
        <!-- Form group untuk nama produk -->
        <div class="form-group nama-produk">
            <label>Nama Produk:</label>
            <input type="text" class="form-control" value="<?php echo $produk['nama']; ?>" readonly>
        </div>
        <!-- Form group untuk harga -->
        <div class="form-group harga">
            <label>Harga:</label>
            <input type="text" class="form-control" value="Rp <?php echo $produk['harga']; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Jumlah:</label>
            <input type="number" name="quantity" class="form-control" min="1" max="<?php echo $produk['stok']; ?>" required>
        </div>
        <!-- Form group untuk saldo -->
        <div class="form-group saldo">
            <label>Saldo Anda:</label>
            <input type="text" class="form-control" value="Rp <?php echo $saldo; ?>" readonly>
        </div>
        <div class="form-group">
            <label>Metode Pembayaran:</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="Kartu Kredit">Kartu Kredit</option>
                <option value="OVO">OVO</option>
                <option value="Gopay">Gopay</option>
                <option value="Dana">Dana</option>
                <option value="Saldo">Saldo</option>
            </select>
        </div>
        <input type="hidden" name="product_id" value="<?php echo $produk['id']; ?>">
        <button type="submit" name="buy" class="btn btn-primary btn-block">Lanjutkan ke Pembayaran</button>
        <a href="beli_barang.php" class="btn btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
    </form>
</div>
<!-- Bootstrap JS dan dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
