<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE produkid = '$id'");
$p = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $namaproduk = $_POST['namaproduk'];
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];

    $update = mysqli_query($koneksi, "UPDATE produk SET namaproduk='$namaproduk', harga='$harga', stok='$stok' WHERE produkid='$id'");

    if ($update) {
        echo "<script>alert('Data produk berhasil diubah!'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah data produk!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
 <link rel="stylesheet" href="style.css?v=99">
<head>
    <title>Edit Produk</title>
</head>

<body>
    <a href="produk.php">Kembali</a>
    <h3> Edit Produk</h3>

    <form method="POST">
        Nama Produk: <br>
        <input type="text" name="namaproduk" value="<?php echo $p['namaproduk']; ?>" required><br><br>

        Harga: <br>
        <input type="number" name="harga" value="<?php echo $p['harga']; ?>" required><br><br>

        Stok: <br>
        <input type="number" name="stok" value="<?php echo $p['stok']; ?>" required><br><br>

        <button type="submit" name="update">Simpan</button>
    </form>
</body>

</html>