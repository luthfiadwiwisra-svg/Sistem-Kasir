<?php
include "config/koneksi.php";

if (!isset($_SESSION['admin'])) {
    header("Location: admin/login.php");
    exit; // ✅ Wajib ada agar berhenti
}

$id = $_GET['id'] ?? 0;
$t = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id='$id'"));

if (!$t) {
    die("Data transaksi tidak ditemukan!");
}

$detail = mysqli_query($koneksi, "SELECT dt.*, b.nama_barang 
                                  FROM detail_transaksi dt 
                                  JOIN barang b ON dt.barang_id = b.id 
                                  WHERE dt.transaksi_id='$id'");

function formatRupiah($angka) {
    return number_format($angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
            line-height: 1.8;
            max-width: 420px;
            margin: 20px auto;
            padding: 15px;
            background: #fff;
        }
        .tengah { text-align: center; }
        .garis {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }
        .baris {
            display: flex;
            width: 100%;
        }
        .nama {
            width: 180px;
            text-align: left;
        }
        .jumlah {
            width: 55px;
            text-align: center;
        }
        .rp-teks {
            width: 45px;
            text-align: left;
        }
        .angka-harga {
            width: 110px;
            text-align: right;
        }
        .info { margin: 4px 0; }
        @media print {
            body { margin: 0; padding: 10px; }
            button { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <h2 class="tengah">L-WISRA MART</h2>
    <p class="tengah">Sistem Kasir Sederhana</p>
    <div class="garis"></div>

    <p class="info">Tanggal : <?= date('Y-m-d H:i:s', strtotime($t['tanggal'])) ?></p>
    <p class="info">Kasir   : <?= !empty($t['kasir']) ? $t['kasir'] : $_SESSION['admin'] ?></p>

    <div class="garis"></div>

    <?php while ($d = mysqli_fetch_assoc($detail)): ?>
    <div class="baris">
        <span class="nama"><?= $d['nama_barang'] ?></span>
        <span class="jumlah">X<?= $d['jumlah'] ?></span>
        <span class="rp-teks">Rp</span>
        <span class="angka-harga"><?= formatRupiah($d['subtotal']) ?></span>
    </div>
    <?php endwhile; ?>

    <div class="garis"></div>

    <div class="baris">
        <span class="nama"><strong>Total</strong></span>
        <span class="jumlah"></span>
        <span class="rp-teks"><strong>Rp</strong></span>
        <span class="angka-harga"><strong><?= formatRupiah($t['total_bayar']) ?></strong></span>
    </div>
    <div class="baris">
        <span class="nama">Uang Bayar</span>
        <span class="jumlah"></span>
        <span class="rp-teks">Rp</span>
        <span class="angka-harga"><?= formatRupiah($t['uang_diberi']) ?></span>
    </div>
    <div class="baris">
        <span class="nama">Kembalian</span>
        <span class="jumlah"></span>
        <span class="rp-teks">Rp</span>
        <span class="angka-harga"><?= formatRupiah($t['kembalian']) ?></span>
    </div>

    <div class="garis"></div>

    <div class="tengah" style="margin-top: 10px;">
        Terima Kasih!<br>
        Semoga Berkunjung Kembali
    </div>
</body>
</html>