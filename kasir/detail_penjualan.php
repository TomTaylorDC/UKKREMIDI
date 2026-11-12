<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);
$p = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM produk WHERE produkid = $id"));
if (!$p) die("Produk tidak ditemukan.");

$sukses = false;
$pid = intval($_GET['pid'] ?? 0);

if (isset($_POST['beli'])) {
    $jml = intval($_POST['jumlah']);
    if ($jml > 0 && $p['stok'] >= $jml) {
        $sub = $p['harga'] * $jml;
        mysqli_query($koneksi, "UPDATE produk SET stok = stok - $jml WHERE produkid = $id");
        mysqli_query($koneksi, "INSERT INTO penjualan (tanggalpenjualan, totalharga) VALUES (NOW(), $sub)");
        $pid = mysqli_insert_id($koneksi);
        mysqli_query($koneksi, "INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, Subtotal) VALUES ($pid, $id, $jml, $sub)");
        $_SESSION['nota'] = ['nama' => $_POST['nama'], 'alamat' => $_POST['alamat'], 'jml' => $jml, 'sub' => $sub];
        header("Location: ?id=$id&pid=$pid");
        exit();
    }
}
if ($pid > 0 && isset($_SESSION['nota'])) $sukses = true;
?>
<h3><?= $sukses ? "Nota Pembelian" : "Beli Produk" ?></h3>
<?php if ($sukses): ?>
    <p>Nama: <?= htmlspecialchars($_SESSION['nota']['nama']) ?><br>Alamat: <?= htmlspecialchars($_SESSION['nota']['alamat']) ?></p>
    <p>Produk: <?= $p['namaproduk'] ?> (<?= $_SESSION['nota']['jml'] ?>x) - Rp <?= number_format($_SESSION['nota']['sub']) ?></p>
    <button onclick="window.print()">Cetak</button> | <a href="pelanggan_produk.php">Kembali</a>
<?php else: ?>
    <form method="POST">
        Nama: <input type="text" name="nama" required><br>
        Alamat: <textarea name="alamat" required></textarea><br>
        Jumlah (Stok: <?= $p['stok'] ?>): <input type="number" name="jumlah" min="1" max="<?= $p['stok'] ?>" required><br><br>
        <button type="submit" name="beli">Proses</button>
    </form>
    <a href="pelanggan_produk.php">Kembali</a>
<?php endif; ?>