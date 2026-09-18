<?php
include "../config/koneksi.php";
if (!isset($_SESSION['admin'])) {
    header("Location: ../admin/login.php");
    exit;
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan - Sistem Kasir</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>
        function hitungTotal() {
            let total = 0;
            const barang = document.querySelectorAll('.barang-item');
            barang.forEach(row => {
                const cek = row.querySelector('input[type="checkbox"]');
                const harga = parseInt(row.dataset.harga);
                const jumlah = parseInt(row.querySelector('.jumlah-input').value) || 0;
                if (cek.checked && jumlah > 0) {
                    total += harga * jumlah;
                }
            });
            document.getElementById('total-bayar').textContent = 'Rp ' + total.toLocaleString('id-ID');
            hitungKembalian();
        }

        function hitungKembalian() {
            const totalText = document.getElementById('total-bayar').textContent;
            const total = parseInt(totalText.replace(/\D/g, '')) || 0;
            const uang = parseInt(document.getElementById('uang_diberi').value) || 0;
            const kembali = uang - total;
            document.getElementById('kembalian').textContent = 'Rp ' + (kembalian >= 0 ? kembali.toLocaleString('id-ID') : '0');
        }
    </script>
</head>
<body>
    <h1>Transaksi Penjualan</h1>
    <a href="../admin/dashboard.php" class="btn">← Kembali ke Dashboard</a>

    <form action="proses_transaksi.php" method="POST">
        <table>
            <tr>
                <th>Pilih Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
            <?php while ($b = mysqli_fetch_assoc($barang)): ?>
            <tr class="barang-item" data-harga="<?= $b['harga'] ?>">
                <td>
                    <input type="checkbox" name="barang_id[]" value="<?= $b['id'] ?>" onchange="hitungTotal()">
                    <?= $b['nama_barang'] ?>
                </td>
                <td>Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
                <td>
                    <input type="text" name="jumlah[<?= $b['id'] ?>]" class="jumlah-input" 
                           placeholder="0" style="width: 80px;"
                           onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                           oninput="hitungTotal()">
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <h3>Total Bayar: <span id="total-bayar">Rp 0</span></h3>
        
        <div style="margin: 15px 0;">
            <label>Uang Diberi:</label><br>
            <input type="text" id="uang_diberi" name="uang_diberi" placeholder="Ketik angka, contoh: 20000" 
                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                   oninput="hitungKembalian()" required>
        </div>

        <h3>Kembalian: <span id="kembalian">Rp 0</span></h3>

        <button type="submit" class="btn">Selesai & Cetak Struk</button>
    </form>
</body>
</html>