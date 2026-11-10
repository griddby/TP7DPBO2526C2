<?php
class Database{
    // Menyimpan koneksi database
    private PDO $conn;

    // Membuat koneksi ke database
    public function __construct(){
        try{
            $this->conn = new PDO("mysql:host=localhost;dbname=db_homeservice", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Koneksi gagal: " . $e->getMessage());
        }
    }

    // Mengembalikan koneksi database
    public function getConnection(): PDO{
        return $this->conn;
    }

    // Memungkinkan class lain mengakses koneksi melalui properti conn
    public function __get(string $name){
        if($name === 'conn'){
            return $this->conn;
        }
        return null;
    }
}