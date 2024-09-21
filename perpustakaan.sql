-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Agu 2024 pada 03.19
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `namabarang` varchar(100) NOT NULL,
  `kondisi` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `namabarang`, `kondisi`, `jumlah`) VALUES
(1, 'Komputer', 'Baik', 5),
(2, 'Meja Baca', 'Baik', 10),
(3, 'Kursi Baca', 'Baik', 20),
(4, 'Proyektor', 'Kurang Baik', 2),
(5, 'Papan Tulis', 'Rusak', 1),
(6, 'Rak Buku', 'Sangat Baik', 8),
(7, 'Printer', 'Baik', 3),
(8, 'Scanner', 'Kurang Baik', 2),
(9, 'AC', 'Baik', 4),
(10, 'Lemari Arsip', 'Kurang Baik', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `no` int(11) NOT NULL,
  `id_buku` varchar(20) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`no`, `id_buku`, `judul_buku`, `pengarang`, `penerbit`, `kategori`, `tahun`, `jumlah`) VALUES
(4, 'K001', 'Politik Riang Gembira', 'Bawedan Anis', 'Penerbit Perubahan', 'Komik', 2024, 24),
(13, 'S002', 'World War II', 'Benjamin', 'Ame Publisher', 'Sejarah', 2010, 49),
(14, 'B001', 'Budidaya Kecebong', 'Jowo Wikodo', 'Salam Publisher', 'Budidaya', 2014, 15),
(16, 'T003', 'Belajar CSS Menyenangkan', 'Chairul Mustafa', 'ASC Publisher', 'Teknologi', 2018, 23),
(17, 'B002', 'Lele Menghasilkan Cuan', 'Budi Agung', 'Farm Farm House', 'Budidaya', 2019, 5),
(18, 'L001', 'Perempuan Hebat', 'Siti Nurhaliza Fadilah', 'Women Publisher', 'Lain-Lain', 2018, 22),
(19, 'T002', 'Ai Teknologi Masa Depan', 'Sanusi Wijaya', 'Pustaka Alvabet', 'Teknologi', 2023, 9),
(21, 'C001', 'Buaya dan Kuda', 'Fania Citra', 'Fabelku', 'Cerpen', 2012, 10),
(22, 'E001', 'Ensiklopedia Tumbuhan', 'Melati Putri', 'Sainsku Publisher', 'Ensiklopedia', 2010, 8),
(23, 'P001', 'Mendisiplinkan Siswa', 'Heri Junaedi', 'Grassroot Media', 'Pendidikan', 2015, 21),
(24, 'A002', 'Biografi Al-Khawarizmi', 'Abdul Somad', 'Bolabundar', 'Agama', 2023, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `username` varchar(12) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(2, 'admin2', '5f4dcc3b5aa7'),
(3, 'admin', '$2y$10$SDUms'),
(4, 'adminperpus', '$2y$10$.8GD.r7eKdzHMeYiO.OX3.51ZdzKLjbEo6DmJWR10hBCIzSo1ww0W');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`no`),
  ADD UNIQUE KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
