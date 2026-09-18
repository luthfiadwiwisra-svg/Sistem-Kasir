<?php
session_start();
// Kalau sudah login, langsung ke dashboard
if (isset($_SESSION['admin'])) {
    header("Location: admin/dashboard.php");
    exit;
}
// Kalau belum login, ke halaman login
header("Location: admin/login.php");
exit;
?>