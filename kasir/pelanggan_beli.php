<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'pelanggan') {
    header("Location: pelanggan_login.php");
    exit();
}
if (!isset($_GET['id'])) {
    die("ID produk tidak diberikan.");
}
$produkid = intval($_GET['id']);

$q = mysqli_query($koneksi, "SELECT * FROM produk WHERE produkid = $produkid");
if (!$q || mysqli_num_rows($q) == 0) {
    die("Produk tidak ditemukan.");
}
$p = mysqli_fetch_assoc($q);

$msg = '';
$totalHarga = 0;

if (isset($_POST['beli'])) {
    $jumlah = intval($_POST['jumlah']);
    $nama_pelanggan = trim($_POST['nama_pelanggan']);
    $alamat = trim($_POST['alamat']);
    $no_telp = trim($_POST['no_telp']);

    if (empty($nama_pelanggan) || empty($alamat) || empty($no_telp)) {
        $msg = "Semua kolom data pengiriman (Nama, Alamat, No. Telp) harus diisi.";
    } elseif ($jumlah <= 0) {
        $msg = "Jumlah tidak valid.";
    } elseif ($p['stok'] >= $jumlah) {
        $newStok = $p['stok'] - $jumlah;
        mysqli_query($koneksi, "UPDATE produk SET stok = $newStok WHERE produkid = $produkid");
        $totalHarga = $p['harga'] * $jumlah;
        $msg = "Pembelian <b>{$p['namaproduk']}</b> sebanyak <b>{$jumlah}</b> unit berhasil!<br>" .
               "<b>Detail Penerima:</b><br>" .
               "Nama: " . htmlspecialchars($nama_pelanggan) . "<br>" .
               "Alamat: " . htmlspecialchars($alamat) . "<br>" .
               "No. Telp: " . htmlspecialchars($no_telp) . "<br><br>" .
               "Stok tersisa: $newStok.<br>Total harga: Rp " . number_format($totalHarga);
    } else {
        $msg = "Stok <b>{$p['namaproduk']}</b> tidak cukup untuk <b>{$jumlah}</b> unit. " .
               "Stok tersedia: {$p['stok']}. Pembelian dibatalkan.";
    }
}
?>
<link rel="stylesheet" href="style.css?v=99">
<h3> Pembelian</h3>

<p>Produk: <strong><?= htmlspecialchars($p['namaproduk']) ?></strong></p>
<p>Harga : Rp <?= number_format($p['harga']) ?></p>
<p>Stok : <?= $p['stok'] ?></p>

<?php if ($msg): ?>
    <p><?= $msg ?></p>
    <br>
    <a href="pelanggan_produk.php">Kembali</a>
<?php else: ?>
    <form method="POST">
        <label>Nama:</label><br>
        <input type="text" name="nama_pelanggan" required><br><br>
        <label>Alamat:</label><br>
        <textarea name="alamat" rows="3" required></textarea><br><br>
        <label>Telepon:</label><br>
        <input type="text" name="no_telp" required><br><br>
        <label>Jumlah:</label><br>
        <input type="number" name="jumlah" min="1" max="<?= $p['stok'] ?>" required><br><br>
        <button type="submit" name="beli">Proses Beli</button>
    </form>
    <br>
    <a href="pelanggan_produk.php">Kembali</a>
<?php endif; ?>