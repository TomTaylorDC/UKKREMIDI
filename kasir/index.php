<?php
include "koneksi.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  
    exit();
}
?>
<link rel="stylesheet" href="style.css?v=99">

<?php if ($_SESSION['role'] === 'pelanggan'): ?>
    <h2><?= htmlspecialchars($_SESSION['namauser']) ?></h2>
    <ul>
        <li><a href="pelanggan_produk.php">Lihat Produk &amp; Beli</a></li>
        <li><a href="pelanggan_logout.php">Logout</a></li>
    </ul>
<?php else: ?>
    <h2><?= htmlspecialchars($_SESSION['namauser']); ?></h2>
    <ul>
        <?php if ($_SESSION['role'] === 'administrator'): ?>
            <li><a href="register.php">Registrasi</a></li>
        <?php endif; ?>
        <li><a href="produk.php">Data Produk</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
<?php endif; ?>