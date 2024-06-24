<?php
session_start();
include "connection.php";

if (isset($_POST['buy'])) {
    $id_produk = $_POST['product_id'];
    $jumlah = $_POST['quantity'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $username = $_SESSION['username'];

    // Periksa stok yang tersedia
    $sql = "SELECT stok, harga FROM barang WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();

    if ($produk['stok'] < $jumlah) {
        echo "<script>alert('Stok tidak mencukupi'); window.location.href='form_pembayaran.php?product_id=$id_produk';</script>";
        exit;
    }

    $total_harga = $produk['harga'] * $jumlah;

    // Periksa saldo pengguna jika metode pembayaran adalah Saldo
    if ($metode_pembayaran == 'Saldo') {
        $sql = "SELECT saldo FROM users WHERE username = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user['saldo'] < $total_harga) {
            echo "<script>alert('Saldo tidak mencukupi'); window.location.href='form_pembayaran.php?product_id=$id_produk';</script>";
            exit;
        }

        // Kurangi saldo pengguna
        $new_saldo = $user['saldo'] - $total_harga;
        $sql = "UPDATE users SET saldo = ? WHERE username = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("is", $new_saldo, $username);
        $stmt->execute();
    }

    // Kurangi stok
    $new_stok = $produk['stok'] - $jumlah;
    $sql = "UPDATE barang SET stok = ? WHERE id = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ii", $new_stok, $id_produk);
    $stmt->execute();

    // Insert data pembelian ke dalam database
    $sql = "INSERT INTO pembelian (username, id_produk, jumlah, metode_pembayaran) VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("siis", $username, $id_produk, $jumlah, $metode_pembayaran);

    if ($stmt->execute()) {
        echo "<script>alert('Pembelian berhasil!'); window.location.href='home.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='form_pembayaran.php?product_id=$id_produk';</script>";
    }

    $stmt->close();
    $koneksi->close();
}
?>
