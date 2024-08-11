-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Agu 2024 pada 20.29
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
-- Database: `db_poskesri`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_balita`
--

CREATE TABLE `data_balita` (
  `id_data_balita` int(11) NOT NULL,
  `nik_balita` varchar(255) NOT NULL,
  `nama_balita` varchar(255) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `nik_ayah` varchar(255) NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `nik_ibu` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `buku_kia` enum('Ada','Tidak Ada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_balita`
--

INSERT INTO `data_balita` (`id_data_balita`, `nik_balita`, `nama_balita`, `tgl_lhr`, `nik_ayah`, `nama_ayah`, `nik_ibu`, `nama_ibu`, `alamat`, `buku_kia`) VALUES
(3, '211', 'NUUR', '2024-07-27', '211', 'adi', '211', 'nuur', 'pasa usang', 'Ada');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_bayi`
--

CREATE TABLE `data_bayi` (
  `id_data_bayi` int(11) NOT NULL,
  `nik_bayi` varchar(255) NOT NULL,
  `nama_bayi` varchar(255) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `jns_kel` enum('laki-laki','perempuan') NOT NULL,
  `nik_ayah` varchar(255) NOT NULL,
  `nama_ayah` varchar(255) NOT NULL,
  `nik_ibu` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `buku_kia` enum('Ada','Tidak Ada') NOT NULL,
  `berat_lhr` varchar(255) NOT NULL,
  `tinggi_lhr` varchar(255) NOT NULL,
  `waktu_kunjungan` enum('Pagi','Sore') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data_bayi`
--

INSERT INTO `data_bayi` (`id_data_bayi`, `nik_bayi`, `nama_bayi`, `tgl_lhr`, `jns_kel`, `nik_ayah`, `nama_ayah`, `nik_ibu`, `nama_ibu`, `alamat`, `buku_kia`, `berat_lhr`, `tinggi_lhr`, `waktu_kunjungan`) VALUES
(3, '1313131', 'ANNUR', '2024-07-26', 'perempuan', '12111', 'ADI', '2121', 'ANNUR', 'PANINTIPUH', 'Ada', '3', '120', 'Pagi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `kegiatan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `tgl`, `waktu_mulai`, `waktu_selesai`, `lokasi`, `kegiatan`) VALUES
(2, '2024-07-27', '01:30:00', '01:30:00', 'SDN 12 ', 'suntik vaksin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `jenis_laporan` varchar(100) NOT NULL,
  `id_data_bayi` int(11) DEFAULT NULL,
  `id_data_balita` int(11) DEFAULT NULL,
  `id_ortu` int(11) DEFAULT NULL,
  `id_jadwal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orang_tua`
--

CREATE TABLE `orang_tua` (
  `id_ortu` int(11) NOT NULL,
  `nama_ortu` varchar(255) NOT NULL,
  `id_data_bayi` int(11) DEFAULT NULL,
  `id_data_balita` int(11) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayanan_balita`
--

CREATE TABLE `pelayanan_balita` (
  `id_pelayanan_balita` int(11) NOT NULL,
  `id_data_balita` int(11) NOT NULL,
  `nama_balita` varchar(100) NOT NULL,
  `id_jadwal` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `berat_badan` float NOT NULL,
  `tinggi_badan` float NOT NULL,
  `vitamin_a` varchar(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelayanan_balita`
--

INSERT INTO `pelayanan_balita` (`id_pelayanan_balita`, `id_data_balita`, `nama_balita`, `id_jadwal`, `lokasi`, `berat_badan`, `tinggi_badan`, `vitamin_a`, `keterangan`) VALUES
(7, 3, 'NUUR', '2', 'SDN 12 ', 3, 100, 'Iya', '-');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayanan_bayi`
--

CREATE TABLE `pelayanan_bayi` (
  `id_pelayanan_bayi` int(11) NOT NULL,
  `id_data_bayi` int(11) NOT NULL,
  `nama_bayi` varchar(255) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `pilihan_imunisasi` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelayanan_bayi`
--

INSERT INTO `pelayanan_bayi` (`id_pelayanan_bayi`, `id_data_bayi`, `nama_bayi`, `id_jadwal`, `lokasi`, `pilihan_imunisasi`, `keterangan`) VALUES
(2, 3, 'ANNUR', 2, 'SDN 12 ', 'Vitamin A', 'demam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tgl_lhr` date NOT NULL,
  `tmp_lhr` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','kader') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `alamat`, `tgl_lhr`, `tmp_lhr`, `username`, `password`, `level`) VALUES
(3, 'fadhila annur', 'Batipuah,Tanah Datar', '2024-07-26', 'Padang Panjang', 'nuur', 'nuur', 'admin'),
(4, 'adi', 'padang', '2024-08-12', 'Padang Panjang', 'admin', 'admin', 'admin'),
(5, 'kader', 'padang', '2024-08-12', 'Padang Panjang', 'kader', 'kader', 'kader');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data_balita`
--
ALTER TABLE `data_balita`
  ADD PRIMARY KEY (`id_data_balita`);

--
-- Indeks untuk tabel `data_bayi`
--
ALTER TABLE `data_bayi`
  ADD PRIMARY KEY (`id_data_bayi`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_data_bayi` (`id_data_bayi`),
  ADD KEY `id_data_balita` (`id_data_balita`),
  ADD KEY `id_ortu` (`id_ortu`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD PRIMARY KEY (`id_ortu`),
  ADD KEY `id_data_bayi` (`id_data_bayi`),
  ADD KEY `id_data_balita` (`id_data_balita`);

--
-- Indeks untuk tabel `pelayanan_balita`
--
ALTER TABLE `pelayanan_balita`
  ADD PRIMARY KEY (`id_pelayanan_balita`);

--
-- Indeks untuk tabel `pelayanan_bayi`
--
ALTER TABLE `pelayanan_bayi`
  ADD PRIMARY KEY (`id_pelayanan_bayi`),
  ADD KEY `id_data_bayi` (`id_data_bayi`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `data_balita`
--
ALTER TABLE `data_balita`
  MODIFY `id_data_balita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `data_bayi`
--
ALTER TABLE `data_bayi`
  MODIFY `id_data_bayi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  MODIFY `id_ortu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pelayanan_balita`
--
ALTER TABLE `pelayanan_balita`
  MODIFY `id_pelayanan_balita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `pelayanan_bayi`
--
ALTER TABLE `pelayanan_bayi`
  MODIFY `id_pelayanan_bayi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`id_data_bayi`) REFERENCES `data_bayi` (`id_data_bayi`),
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`id_data_balita`) REFERENCES `data_balita` (`id_data_balita`),
  ADD CONSTRAINT `laporan_ibfk_3` FOREIGN KEY (`id_ortu`) REFERENCES `orang_tua` (`id_ortu`),
  ADD CONSTRAINT `laporan_ibfk_4` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`);

--
-- Ketidakleluasaan untuk tabel `orang_tua`
--
ALTER TABLE `orang_tua`
  ADD CONSTRAINT `orang_tua_ibfk_1` FOREIGN KEY (`id_data_bayi`) REFERENCES `data_bayi` (`id_data_bayi`),
  ADD CONSTRAINT `orang_tua_ibfk_2` FOREIGN KEY (`id_data_balita`) REFERENCES `data_balita` (`id_data_balita`);

--
-- Ketidakleluasaan untuk tabel `pelayanan_bayi`
--
ALTER TABLE `pelayanan_bayi`
  ADD CONSTRAINT `pelayanan_bayi_ibfk_1` FOREIGN KEY (`id_data_bayi`) REFERENCES `data_bayi` (`id_data_bayi`),
  ADD CONSTRAINT `pelayanan_bayi_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
