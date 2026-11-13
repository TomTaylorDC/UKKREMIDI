<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<link rel="stylesheet" href="style.css?v=99">
<h3>Produk</h3>
<a href="index.php">Kembali</a>
<br><br>
<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
    <?php $no = 1; while ($p = mysqli_fetch_assoc($produk)) { ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $p['namaproduk']; ?></td>
            <td>Rp <?php echo number_format($p['harga']); ?></td>
            <td><?php echo $p['stok']; ?></td>
            <td>
                <a href="edit_produk.php?id=<?php echo $p['produkid']; ?>">Edit</a> | 
                 <a href="tambah.php">Tambah Produk</a>  | 
                <a href="hapus.php?id=<?php echo $p['produkid']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a> 
            </td>
        </tr>
    <?php } ?>
</table>