CREATE DATABASE db_homeservice;
USE db_homeservice;

CREATE TABLE customers(
    id_customer INT AUTO_INCREMENT PRIMARY KEY, 
    nama_customer VARCHAR(255) NOT NULL, 
    email VARCHAR(100) NOT NULL UNIQUE, 
    no_telepon VARCHAR(20) NOT NULL
);

CREATE TABLE services(
    id_service INT AUTO_INCREMENT PRIMARY KEY,
    nama_service VARCHAR(100) NOT NULL,
    deskripsi TEXT NULL,
    durasi INT NOT NULL,
    harga DECIMAL(10, 2) NOT NULL
);

CREATE TABLE bookings(
    id_booking INT AUTO_INCREMENT PRIMARY KEY,
    id_customer INT NOT NULL,
    id_service INT NOT NULL,
    tanggal_booking DATE NOT NULL DEFAULT(CURRENT_DATE),
    jam_booking TIME NOT NULL,
    jenis_properti ENUM('Rumah', 'Apartemen', 'Kos') NOT NULL,
    alamat_layanan TEXT NOT NULL,
    catatan TEXT NULL,
    status_booking ENUM('Pending', 'Confirmed', 'In Progress', 'Completed', 'Cancelled') NOT NULL DEFAULT 'Pending',
    total_harga DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY(id_customer) REFERENCES customers(id_customer),
    FOREIGN KEY(id_service) REFERENCES services(id_service)
);

INSERT INTO customers (nama_customer, email, no_telepon) VALUES
('Andi Pratama', 'andi@gmail.com', '081234567890'),
('Siti Rahmawati', 'siti@gmail.com', '082345678901'),
('Budi Santoso', 'budi@gmail.com', '083456789012'),
('Dewi Anggraini', 'dewi@gmail.com', '085678901234'),
('Rizky Maulana', 'rizky@gmail.com', '087890123456');

INSERT INTO services (nama_service, deskripsi, durasi, harga) VALUES
('Regular Cleaning', 'Pembersihan rutin meliputi menyapu, mengepel, membersihkan debu, dan merapikan ruangan.', 120, 150000),
('Deep Cleaning', 'Pembersihan menyeluruh pada seluruh bagian ruangan termasuk area yang sulit dijangkau.', 240, 350000),
('Bathroom Cleaning', 'Pembersihan kamar mandi meliputi lantai, toilet, wastafel, dan dinding.', 60, 75000),
('Kitchen Cleaning', 'Pembersihan dapur meliputi kompor, wastafel, meja dapur, dan area memasak.', 90, 100000),
('Bedroom Cleaning', 'Pembersihan kamar tidur meliputi tempat tidur, lantai, lemari, dan permukaan perabot.', 90, 100000),
('Move In / Move Out Cleaning', 'Pembersihan menyeluruh sebelum menempati atau setelah meninggalkan properti.', 300, 450000);

INSERT INTO bookings (id_customer, id_service, tanggal_booking, jam_booking, jenis_properti, alamat_layanan, catatan, status_booking, total_harga) VALUES
(1, 1, '2026-11-08', '08:00:00', 'Rumah', 'Jl. Gegerkalong Girang No. 25, Bandung', 'Fokus membersihkan ruang tamu dan kamar tidur.', 'Completed', 150000),
(2, 2, '2026-11-08', '10:00:00', 'Apartemen', 'Apartemen Gateway, Bandung', 'Pembersihan menyeluruh seluruh ruangan.', 'In Progress', 350000),
(3, 3, '2026-11-09', '09:00:00', 'Kos', 'Jl. Setiabudi No. 120, Bandung', 'Kamar mandi memiliki noda membandel.', 'Confirmed', 75000),
(4, 4, '2026-11-09', '13:00:00', 'Rumah', 'Jl. Sarijadi No. 45, Bandung', 'Mohon bersihkan area kompor dan wastafel.', 'Pending', 100000),
(5, 5, '2026-11-10', '08:30:00', 'Kos', 'Jl. Dr. Setiabudi No. 89, Bandung', 'Fokus pada kamar tidur dan lemari.', 'Pending', 100000),
(1, 6, '2026-11-10', '10:00:00', 'Apartemen', 'Apartemen Grand Setiabudi, Bandung', 'Properti baru selesai renovasi.', 'Cancelled', 450000);