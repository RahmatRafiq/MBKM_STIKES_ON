
-- Membuat database "sisfo"
CREATE DATABASE sisfo;

-- Menggunakan database "sisfo"
USE sisfo;

-- Membuat tabel "mahasiswa"
CREATE TABLE mahasiswa (
    id_mahasiswa INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    jurusan VARCHAR(50) NOT NULL,
    tahun_masuk YEAR NOT NULL
);

-- Membuat tabel "dosen"
CREATE TABLE dosen (
    id_dosen INT AUTO_INCREMENT PRIMARY KEY,
    nip VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    departemen VARCHAR(50) NOT NULL,
    tahun_mulai YEAR NOT NULL
);

-- Dump data 20 data mahasiswa
INSERT INTO mahasiswa (nim, nama, tanggal_lahir, alamat, jurusan, tahun_masuk) VALUES
('M001', 'Ahmad Fauzi', '2000-01-01', 'Jl. Merdeka No.1, Jakarta', 'Teknik Informatika', 2018),
('M002', 'Budi Santoso', '2001-02-02', 'Jl. Jendral Sudirman No.2, Bandung', 'Sistem Informasi', 2019),
('M003', 'Citra Dewi', '1999-03-03', 'Jl. Gatot Subroto No.3, Surabaya', 'Teknik Informatika', 2017),
('M004', 'Dewi Sartika', '2000-04-04', 'Jl. Ahmad Yani No.4, Medan', 'Teknik Industri', 2018),
('M005', 'Eko Wijaya', '2001-05-05', 'Jl. Diponegoro No.5, Yogyakarta', 'Teknik Mesin', 2019),
('M006', 'Fitri Lestari', '1998-06-06', 'Jl. Malioboro No.6, Malang', 'Teknik Elektro', 2016),
('M007', 'Gilang Ramadhan', '2000-07-07', 'Jl. Pahlawan No.7, Semarang', 'Teknik Kimia', 2018),
('M008', 'Hendra Saputra', '1999-08-08', 'Jl. Imam Bonjol No.8, Palembang', 'Teknik Sipil', 2017),
('M009', 'Indra Gunawan', '2001-09-09', 'Jl. Dipati Ukur No.9, Bogor', 'Arsitektur', 2019),
('M010', 'Joko Susilo', '1998-10-10', 'Jl. Gajah Mada No.10, Makassar', 'Teknik Lingkungan', 2016),
('M011', 'Kurniawan', '2000-11-11', 'Jl. Hayam Wuruk No.11, Pontianak', 'Sistem Informasi', 2018),
('M012', 'Lestari Puspita', '2001-12-12', 'Jl. Asia Afrika No.12, Balikpapan', 'Teknik Industri', 2019),
('M013', 'Mahendra', '1999-01-13', 'Jl. Sunda No.13, Banda Aceh', 'Teknik Mesin', 2017),
('M014', 'Nina Agustin', '2000-02-14', 'Jl. Veteran No.14, Mataram', 'Teknik Elektro', 2018),
('M015', 'Oktavia Sari', '1998-03-15', 'Jl. Dr. Soetomo No.15, Ambon', 'Teknik Informatika', 2016),
('M016', 'Putri Ayu', '2001-04-16', 'Jl. Ahmad Dahlan No.16, Jambi', 'Teknik Sipil', 2019),
('M017', 'Qorina Rahma', '1999-05-17', 'Jl. Pattimura No.17, Tasikmalaya', 'Teknik Kimia', 2017),
('M018', 'Rudi Hartono', '2000-06-18', 'Jl. Dewi Sartika No.18, Kendari', 'Arsitektur', 2018),
('M019', 'Siti Aisyah', '2001-07-19', 'Jl. Raden Intan No.19, Padang', 'Teknik Lingkungan', 2019),
('M020', 'Taufik Hidayat', '1998-08-20', 'Jl. Perintis Kemerdekaan No.20, Manado', 'Sistem Informasi', 2016);

-- Dump data 20 data dosen
INSERT INTO dosen (nip, nama, tanggal_lahir, alamat, departemen, tahun_mulai) VALUES
('D001', 'Prof. Dr. Andi Hidayat', '1970-01-01', 'Jl. Merdeka No.1, Jakarta', 'Teknik Informatika', 2000),
('D002', 'Dr. Budi Satria', '1972-02-02', 'Jl. Jendral Sudirman No.2, Bandung', 'Sistem Informasi', 2002),
('D003', 'Ir. Citra Wibowo', '1974-03-03', 'Jl. Gatot Subroto No.3, Surabaya', 'Teknik Informatika', 2004),
('D004', 'Dr. Dewi Anggraeni', '1976-04-04', 'Jl. Ahmad Yani No.4, Medan', 'Teknik Industri', 2006),
('D005', 'Ir. Eko Nugroho', '1978-05-05', 'Jl. Diponegoro No.5, Yogyakarta', 'Teknik Mesin', 2008),
('D006', 'Prof. Fitri Kusuma', '1980-06-06', 'Jl. Malioboro No.6, Malang', 'Teknik Elektro', 2010),
('D007', 'Dr. Gilang Fajar', '1982-07-07', 'Jl. Pahlawan No.7, Semarang', 'Teknik Kimia', 2012),
('D008', 'Ir. Hendra Setiawan', '1984-08-08', 'Jl. Imam Bonjol No.8, Palembang', 'Teknik Sipil', 2014),
('D009', 'Prof. Indra Kusuma', '1986-09-09', 'Jl. Dipati Ukur No.9, Bogor', 'Arsitektur', 2016),
('D010', 'Dr. Joko Sutrisno', '1988-10-10', 'Jl. Gajah Mada No.10, Makassar', 'Teknik Lingkungan', 2018),
('D011', 'Ir. Kurniawan Fajar', '1971-11-11', 'Jl. Hayam Wuruk No.11, Pontianak', 'Sistem Informasi', 2001),
('D012', 'Prof. Lestari Puspa', '1973-12-12', 'Jl. Asia Afrika No.12, Balikpapan', 'Teknik Industri', 2003),
('D013', 'Dr. Mahendra Kusuma', '1975-01-13', 'Jl. Sunda No.13, Banda Aceh', 'Teknik Mesin', 2005),
('D014', 'Ir. Nina Kusuma', '1977-02-14', 'Jl. Veteran No.14, Mataram', 'Teknik Elektro', 2007),
('D015', 'Prof. Oktavia Sari', '1979-03-15', 'Jl. Dr. Soetomo No.15, Ambon', 'Teknik Informatika', 2009),
('D016', 'Dr. Putri Andini', '1981-04-16', 'Jl. Ahmad Dahlan No.16, Jambi', 'Teknik Sipil', 2011),
('D017', 'Ir. Qorina Santoso', '1983-05-17', 'Jl. Pattimura No.17, Tasikmalaya', 'Teknik Kimia', 2013),
('D018', 'Prof. Rudi Hartono', '1985-06-18', 'Jl. Dewi Sartika No.18, Kendari', 'Arsitektur', 2015),
('D019', 'Dr. Siti Munawaroh', '1987-07-19', 'Jl. Raden Intan No.19, Padang', 'Teknik Lingkungan', 2017),
('D020', 'Ir. Taufik Ismail', '1989-08-20', 'Jl. Perintis Kemerdekaan No.20, Manado', 'Sistem Informasi', 2019);
