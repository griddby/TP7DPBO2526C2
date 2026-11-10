<?php 
require_once __DIR__ . '/../config/db.php';

class Service{
    // Menyimpan koneksi database
    private PDO $db;

    // Membuat koneksi database saat objek dibuat
    public function __construct(){
        $this->db = (new Database())->conn;
    }

    // Mengambil seluruh data service
    public function getAllService(): array{
        $stmt = $this->db->prepare("SELECT * FROM services");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data service berdasarkan ID
    public function getServiceById(int $id_service): array|false{
        $stmt = $this->db->prepare("SELECT * FROM services WHERE id_service = ?");
        $stmt->execute([$id_service]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan data service
    public function createService(string $nama_service, ?string $deskripsi, int $durasi, float $harga): bool{
        $stmt = $this->db->prepare("INSERT INTO services(nama_service, deskripsi, durasi, harga) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nama_service, $deskripsi, $durasi, $harga]);
    }

    // Mengubah data service
    public function updateService(string $nama_service, ?string $deskripsi, int $durasi, float $harga, int $id_service): bool{
        $stmt = $this->db->prepare("UPDATE services SET nama_service = ?, deskripsi = ?, durasi = ?, harga = ? WHERE id_service = ?");
        return $stmt->execute([$nama_service, $deskripsi, $durasi, $harga, $id_service]);
    }

    // Menghapus data service berdasarkan ID
    public function deleteService(int $id_service): bool{
        try{
            $stmt = $this->db->prepare("DELETE FROM services WHERE id_service = ?");
            return $stmt->execute([$id_service]);
        } catch(PDOException){
            return false;
        }
    }
}