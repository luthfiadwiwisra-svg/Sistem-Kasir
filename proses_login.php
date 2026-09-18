<?php
include "../config/koneksi.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
$admin = mysqli_fetch_assoc($query);

if ($admin) {
    $_SESSION['admin'] = $admin['username'];
    header("Location: dashboard.php");
    exit;
} else {
    echo "<script>alert('Username atau Password salah!');history.back()</script>";
}
?>