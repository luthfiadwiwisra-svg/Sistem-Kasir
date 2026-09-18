<?php
include "../config/koneksi.php";

if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: buat_transaksi.php");
    exit;
}

$barang_id = $_POST['barang_id'] ?? [];
$jumlah = $_POST['jumlah'] ?? [];
$uang_diberi = (int)$_POST['uang_diberi'];
$nama_kasir = $_SESSION['admin'];

if (empty($barang_id)) {
    echo "<script>alert('Pilih dulu barang yang dibeli!');history.back()</script>";
    exit;
}

$total_bayar = 0;
$tanggal = date('Y-m-d H:i:s');

// Simpan transaksi
mysqli_query($koneksi, "INSERT INTO transaksi (tanggal, kasir, total_bayar, uang_diberi, kembalian)
                        VALUES ('$tanggal', '$nama_kasir', '0', '$uang_diberi', '0')");
$transaksi_id = mysqli_insert_id($koneksi);

// Proses setiap barang
foreach ($barang_id as $id) {
    $jml = (int)($jumlah[$id] ?? 0);
    if ($jml <= 0) continue;

    $b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga, stok FROM barang WHERE id='$id'"));
    $harga = $b['harga'];
    $subtotal = $harga * $jml;
    $total_bayar += $subtotal;

    // Simpan rincian
    mysqli_query($koneksi, "INSERT INTO detail_transaksi (transaksi_id, barang_id, jumlah, subtotal)
                            VALUES ('$transaksi_id', '$id', '$jml', '$subtotal')");

    // Kurangi stok
    $stok_baru = $b['stok'] - $jml;
    mysqli_query($koneksi, "UPDATE barang SET stok='$stok_baru' WHERE id='$id'");
}

// Update total & kembalian
$kembalian = $uang_diberi - $total_bayar;
mysqli_query($koneksi, "UPDATE transaksi SET total_bayar='$total_bayar', kembalian='$kembalian' WHERE id='$transaksi_id'");

// Arahkan ke struk — jalur sudah diperbaiki!
header("Location: ../cetak_struk.php?id=$transaksi_id");
exit;
?>