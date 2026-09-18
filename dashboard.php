	<?php
// Jika BELUM login → ke login
	include "../config/koneksi.php";
	if (!isset($_SESSION['admin'])) {
	    header("Location: login.php");
	    exit;
	}
	
	$jml_barang = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM barang"));
	$jml_transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM transaksi"));
	?>
	<!DOCTYPE html>
	<html>
	<head>
	    <title>Dashboard - Sistem Kasir</title>
	    <link rel="stylesheet" href="../assets/style.css">
	</head>
	<body>
	    <h1>Selamat Datang, <?= $_SESSION['admin'] ?>!</h1>
	    <p style="margin-bottom: 20px;">Ini Halaman Utama Sistem Kasir</p>
	    
	    <div>
	        <a href="barang.php" class="btn">Kelola Data Barang</a>
	        <a href="../transaksi/buat_transaksi.php" class="btn">Transaksi Penjualan</a>
	        <a href="../transaksi/laporan.php" class="btn">Laporan Penjualan</a>
	        <a href="logout.php" class="btn" style="background: #ef5350;">Logout</a>
	    </div>
	    
	    <h3 style="margin-top: 30px;">Ringkasan</h3>
	    <div style="background:white; padding:20px; border-radius:8px; max-width:400px;">
	        <p style="font-size: 16px; margin: 10px 0;">Jumlah Barang: <strong><?= $jml_barang ?></strong></p>
	        <p style="font-size: 16px; margin: 10px 0;">Jumlah Transaksi: <strong><?= $jml_transaksi ?></strong></p>
	    </div>
	</body>
	</html>