<?php
session_start();
include "connection.php";

if (isset($_POST['tambah_produk'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Proses upload gambar
    $gambar_produk = $_FILES['gambar']['name'];
    $temp_file = $_FILES['gambar']['tmp_name'];
    $target_directory = "barang/";
    $target_file = $target_directory . basename($gambar_produk);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Cek apakah file adalah gambar
    $check = getimagesize($temp_file);
    if($check === false) {
        echo "File yang diunggah bukan gambar.";
        $uploadOk = 0;
    }

    // Cek jika file sudah ada
    if (file_exists($target_file)) {
        echo "Maaf, file gambar sudah ada.";
        $uploadOk = 0;
    }

    // Batasi jenis file yang diizinkan
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk bernilai 0
    if ($uploadOk == 0) {
        echo "Maaf, gambar Anda tidak diunggah.";
    // Jika semua ok, coba upload file
    } else {
        if (move_uploaded_file($temp_file, $target_file)) {
            // Masukkan data ke dalam database
            $sql = "INSERT INTO barang (nama, harga, stok, gambar_barang) VALUES ('$nama', '$harga', '$stok', '$gambar_produk')";
            if ($koneksi->query($sql) === TRUE) {
                echo "Produk baru berhasil ditambahkan.";
            } else {
                echo "Error: " . $sql . "<br>" . $koneksi->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah gambar Anda.";
        }
    }

    $koneksi->close();
    header("Location: tambah_produk.php");
    exit();
}
?>
