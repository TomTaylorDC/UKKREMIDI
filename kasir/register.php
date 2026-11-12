<?php
include "koneksi.php";
session_start();

if (isset($_POST['daftar'])) {
    $allowedRoles = ['administrator', 'kasir', 'pelanggan'];
    $role = in_array($_POST['role'], $allowedRoles) ? $_POST['role'] : 'kasir';

    mysqli_query(
        $koneksi,
        "INSERT INTO user (namauser, username, password, role) VALUES (
            '{$_POST['namauser']}',
            '{$_POST['username']}',
            '{$_POST['password']}',
            '{$role}'
        )"
    );

    echo "<script>alert('Berhasil!'); window.location='index.php';</script>";
    exit();
}
?>
<link rel="stylesheet" href="style.css?v=99">
<a href="index.php">Kembali</a>

<form method="POST">
    <h3>Registrasi User</h3>
    Nama    : <input type="text" name="namauser" required><br><br>
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    Role    : <select name="role" required>
                <option value="administrator">Administrator</option>
                <option value="kasir">Petugas</option>
                <option value="pelanggan">Pelanggan</option>
             </select><br><br>

    <button type="submit" name="daftar">Simpan</button>
</form>