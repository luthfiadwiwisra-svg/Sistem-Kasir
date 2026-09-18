<?php
include "../config/koneksi.php";

// Jika SUDAH login → langsung ke dashboard
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit; // WAJIB ada agar berhenti
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistem Kasir</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="login-box">
        <h2>Login Sistem Kasir</h2>
        <?php
        if (isset($_GET['pesan'])) {
            echo "<p class='error'>".$_GET['pesan']."</p>";
        }
        ?>
        <form action="proses_login.php" method="POST">
            <div>
                <label>Nama Pengguna</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>Kata Sandi</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Masuk</button>
        </form>
    </div>
</body>
</html>