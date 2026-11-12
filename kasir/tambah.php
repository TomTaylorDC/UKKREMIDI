<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['simpan'])) {
    $namaproduk = $_POST['namaproduk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($koneksi, "INSERT INTO produk (namaproduk, harga, stok) VALUES ('$namaproduk', '$harga', '$stok')");
    header("Location: produk.php");
    exit();
}
?>
<link rel="stylesheet" href="style.css?v=99">
<h3>Tambah</h3>
<a href="produk.php">Kembali</a>
<br><br>
<form method="POST">
    Nama Produk: <input type="text" name="namaproduk" required><br><br>
    Harga: <input type="number" name="harga" required><br><br>
    Stok: <input type="number" name="stok" required><br><br>
    <button type="submit" name="simpan">Simpan</button>
</form>