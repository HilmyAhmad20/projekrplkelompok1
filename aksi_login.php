<?php
session_start();
include "connection.php";
$user = $_POST['username'];
$psw = $_POST['password'];
$op = $_GET['op'];

if ($op = "in") {
$sql = "SELECT * from user where username='$user' AND password='$psw'";
$query = $koneksi->query($sql);
if (mysqli_num_rows($query) == 1) {
$data = $query->fetch_array();
$_SESSION['username'] = $data['username'];
echo $data['level'];
if ($data['level'] == "Admin") {
header("location:home.php");
} else if ($data['level'] == "Pengguna") {
header("location:home.php");
} else {
die("password salah <a href=\"javascript:history.back()\">kembali</a>");
}
}
} else if ($op == "out") {
unset($_SESSION['username']);
unset($_SESSION['level']);
header("location:login.php");
}