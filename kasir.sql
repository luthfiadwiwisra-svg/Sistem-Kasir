-- Buat database
CREATE DATABASE IF NOT EXISTS kasir_sederhana;
USE kasir_sederhana;

-- Tabel Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Tabel Barang
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT NOT NULL
);

-- Tabel Transaksi
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_bayar DECIMAL(10,2) NOT NULL,
    uang_diberi DECIMAL(10,2) NOT NULL,
    kembalian DECIMAL(10,2) NOT NULL
);

-- Tabel Detail Transaksi
CREATE TABLE detail_transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    jumlah INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
    FOREIGN KEY (barang_id) REFERENCES barang(id)
);

-- Data Admin Contoh (username: admin, password: 123456)
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$EixZaYb2U5Rq0u7vWkPzHeX/.t5G.1h1j2k3l4m5n6o7p8q9r0s1t2');