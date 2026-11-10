<?php
require_once __DIR__ . '/../config/db.php';

class Customer{
    // Menyimpan koneksi database
    private PDO $db;

    // Membuat koneksi database saat objek dibuat
    public function __construct(){
        $this->db = (new Database())->conn;
    }

    // Mengambil seluruh data customer
    public function getAllCustomer(): array{
        $stmt = $this->db->prepare("SELECT * FROM customers");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil data customer berdasarkan ID
    public function getAllCustomerById(int $id_customer): array|false{
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id_customer = ?");
        $stmt->execute([$id_customer]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan data customer
    public function createCustomer(string $nama_customer, string $email, string $no_telepon): bool{
        $stmt = $this->db->prepare("INSERT INTO customers(nama_customer, email, no_telepon) VALUES (?, ?, ?)");
        return $stmt->execute([$nama_customer, $email, $no_telepon]);
    }

    // Mengubah data customer
    public function updateCustomer(int $id_customer, string $nama_customer, string $email, string $no_telepon): bool{
        $stmt = $this->db->prepare("UPDATE customers SET nama_customer = ?, email = ?, no_telepon = ? WHERE id_customer = ?");
        return $stmt->execute([$nama_customer, $email, $no_telepon, $id_customer]);
    }

    // Menghapus data customer berdasarkan ID
    public function deleteCustomer(int $id_customer): bool{
        try{
            $stmt = $this->db->prepare("DELETE FROM customers WHERE id_customer = ?");
            return $stmt->execute([$id_customer]);
        } catch(PDOException){
            return false;
        }
    }
}