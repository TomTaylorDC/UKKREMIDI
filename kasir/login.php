<?php
include "koneksi.php";
session_start();

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $q = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$u' AND password='$p'");
    if (mysqli_num_rows($q) == 1) {
        $d = mysqli_fetch_assoc($q);
        $_SESSION['user_id'] = $d['id'];
        $_SESSION['namauser'] = $d['namauser'];
        $_SESSION['role'] = $d['role'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Login Gagal!');</script>";
    }
}
?>
 <link rel="stylesheet" href="style.css?v=99">
<form method="POST">
    <h3>Login Kasir</h3>
    username: <input type="text" name="username" required><br><br>
    password: <input type="password" name="password" required><br><br>
    <button type="submit" name="login">Login</button>
</form>