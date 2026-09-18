<?php
include "../config/koneksi.php";
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Tambah Barang
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    mysqli_query($koneksi, "INSERT INTO barang (nama_barang, harga, stok) VALUES ('$nama', '$harga', '$stok')");
    header("Location: barang.php");
    exit;
}

// Hapus Barang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM detail_transaksi WHERE barang_id='$id'");
    mysqli_query($koneksi, "DELETE FROM barang WHERE id='$id'");
    header("Location: barang.php");
    exit;
}

$data_barang = mysqli_query($koneksi, "SELECT * FROM barang");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Barang - Sistem Kasir</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <h1>Kelola Data Barang</h1>
    <a href="dashboard.php" class="btn">← Kembali ke Dashboard</a>

    <h3 style="margin-top: 30px;">Tambah Barang Baru</h3>
    <form method="POST">
        <div>
            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" placeholder="Contoh: Buku Tulis" required>
        </div>
        <div>
            <label>Harga (ketik angka penuh, contoh: 4000):</label><br>
            <input type="number" name="harga" placeholder="Contoh: 4000" required>
        </div>
        <div>
            <label>Stok:</label><br>
            <input type="number" name="stok" placeholder="Contoh: 50" required>
        </div>
        <button type="submit" name="tambah" class="btn">Simpan Barang</button>
    </form>

    <h3>Daftar Barang</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1; while($b=mysqli_fetch_assoc($data_barang)): 
            // Ubah format harga di sini, langsung dari kode
            $harga_benar = (int)$b['harga']; // Pastikan jadi angka
            $harga_format = number_format($harga_benar, 0, ',', '.');
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $b['nama_barang'] ?></td>
            <td class="rp">Rp <?= $harga_format ?></td>
            <td><?= $b['stok'] ?></td>
            <td>
                <a href="barang.php?hapus=<?= $b['id'] ?>" onclick="return confirm('Yakin hapus barang ini?')" style="color:#dc2626;">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>