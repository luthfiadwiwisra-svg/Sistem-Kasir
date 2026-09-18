<?php
include "../config/koneksi.php";
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit;
}

$laporan = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan - Sistem Kasir</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Laporan Penjualan</h1>
    
    <div>
        <a href="buat_transaksi.php" class="btn">Transaksi Baru</a>
        <a href="../admin/dashboard.php" class="btn">Kembali ke Dashboard</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kasir</th>
            <th>Total Bayar</th>
            <th>Uang Diberi</th>
            <th>Kembalian</th>
        </tr>
        <?php $no = 1; while ($l = mysqli_fetch_assoc($laporan)): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $l['tanggal'] ?></td>
            <td><?= $l['kasir'] ?></td>
            <td class="rp">Rp <?= number_format($l['total_bayar'], 0, ',', '.') ?></td>
            <td class="rp">Rp <?= number_format($l['uang_diberi'], 0, ',', '.') ?></td>
            <td class="rp">Rp <?= number_format($l['kembalian'], 0, ',', '.') ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>