CREATE DATABASE IF NOT EXISTS peminjaman_ruangan;
USE peminjaman_ruangan;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL
);

INSERT INTO users(username,password) VALUES('admin','admin123')
ON DUPLICATE KEY UPDATE username=username;

CREATE TABLE IF NOT EXISTS ruangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    lokasi VARCHAR(150) NOT NULL,
    kapasitas INT NOT NULL,
    fasilitas VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ruangan_id INT NOT NULL,
    nama_peminjam VARCHAR(100) NOT NULL,
    kegiatan VARCHAR(200) NOT NULL,
    tanggal DATE NOT NULL,
    waktu_mulai TIME NOT NULL,
    waktu_selesai TIME NOT NULL,
    status ENUM('Menunggu','Disetujui','Ditolak') NOT NULL DEFAULT 'Menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ruangan_id) REFERENCES ruangan(id)
);

INSERT INTO ruangan(nama,lokasi,kapasitas,fasilitas) VALUES
('Ruang Rapat A','Gedung A Lantai 1',20,'AC, LCD, Wi-Fi'),
('Ruang Seminar','Gedung B Lantai 2',80,'AC, LCD, Sound System'),
('Laboratorium Komputer 1','Gedung C Lantai 1',35,'Komputer, AC, Proyektor'),
('Ruang Kelas 101','Gedung A Lantai 2',40,'AC, LCD, Papan Tulis');
