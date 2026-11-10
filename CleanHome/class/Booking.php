<?php
require_once __DIR__ . '/../config/db.php';

class Booking{
    // Menyimpan koneksi database
    private PDO $db;

    // Membuat koneksi database saat objek dibuat
    public function __construct(){
        $this->db = (new Database())->conn;
    }

    // Mengambil seluruh data booking
    public function getAllBooking(): array{
        $stmt = $this->db->prepare("SELECT * FROM bookings");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data booking berdasarkan ID
    public function getBookingById(int $id_booking): array|false{
        $stmt = $this->db->prepare("SELECT * FROM bookings WHERE id_booking = ?");
        $stmt->execute([$id_booking]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan data booking
    public function createBooking(int $id_customer, int $id_service, string $tanggal_booking, string $jam_booking, string $jenis_properti, string $alamat_layanan, ?string $catatan, string $status_booking, float $total_harga): bool{
        $stmt = $this->db->prepare("INSERT INTO bookings(id_customer, id_service, tanggal_booking, jam_booking, jenis_properti, alamat_layanan, catatan, status_booking, total_harga) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$id_customer, $id_service, $tanggal_booking, $jam_booking, $jenis_properti, $alamat_layanan, $catatan, $status_booking, $total_harga]);
    }

    // Mengubah data booking
    public function updateBooking(int $id_customer, int $id_service, string $tanggal_booking, string $jam_booking, string $jenis_properti, string $alamat_layanan, ?string $catatan, string $status_booking, float $total_harga, int $id_booking): bool{
        $stmt = $this->db->prepare("UPDATE bookings SET id_customer = ?, id_service = ?, tanggal_booking = ?, jam_booking = ?, jenis_properti = ?, alamat_layanan = ?, catatan = ?, status_booking = ?, total_harga = ? WHERE id_booking = ?");
        return $stmt->execute([$id_customer, $id_service, $tanggal_booking, $jam_booking, $jenis_properti, $alamat_layanan, $catatan, $status_booking, $total_harga, $id_booking]);
    }

    // Menghapus data booking berdasarkan ID
    public function deleteBooking(int $id_booking):  bool{
        try{
            $stmt = $this->db->prepare("DELETE FROM bookings WHERE id_booking = ?");
            return $stmt->execute([$id_booking]);
        } catch(PDOException){
            return false;
        }
    }
}