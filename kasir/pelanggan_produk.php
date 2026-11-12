<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pelanggan') {
    header("Location: pelanggan_login.php");
    exit();
}
$produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<link rel="stylesheet" href="style.css?v=99">
<h3>Daftar</h3>
<a href="index.php">Kembali</a><br><br>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th><th>Nama Produk</th><th>Harga</th><th>Stok</th><th>Aksi</th>
    </tr>
    <?php $no = 1; while ($p = mysqli_fetch_assoc($produk)): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($p['namaproduk']) ?></td>
        <td>Rp <?= number_format($p['harga']) ?></td>
        <td><?= $p['stok'] ?></td>
        <td>
            <a href="pelanggan_beli.php?id=<?= $p['produkid'] ?>">Beli</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>