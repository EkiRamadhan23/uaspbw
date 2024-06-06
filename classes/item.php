<?php
include_once 'Database.php';

class Item
{
    private $conn;
    private $table_name = "items";

    public $id;
    public $tanggal;
    public $nama_barang;
    public $batch;
    public $total;
    public $status_payment;
    public $status_barang;
    public $foto_arrived_wh_kr;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (tanggal, nama_barang, batch, total, status_payment, status_barang, foto_arrived_wh_kr) VALUES (:tanggal, :nama_barang, :batch, :total, :status_payment, :status_barang, :foto_arrived_wh_kr)");
        $stmt->bindParam(':tanggal', $this->tanggal);
        $stmt->bindParam(':nama_barang', $this->nama_barang);
        $stmt->bindParam(':batch', $this->batch);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':status_payment', $this->status_payment);
        $stmt->bindParam(':status_barang', $this->status_barang);
        $stmt->bindParam(':foto_arrived_wh_kr', $this->foto_arrived_wh_kr);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function readAll()
    {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table_name");
        $stmt->execute();
        return $stmt;
    }

    public function update()
    {
        $stmt = $this->conn->prepare("UPDATE $this->table_name SET tanggal = :tanggal, nama_barang = :nama_barang, batch = :batch, total = :total, status_payment = :status_payment, status_barang = :status_barang, foto_arrived_wh_kr = :foto_arrived_wh_kr WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':tanggal', $this->tanggal);
        $stmt->bindParam(':nama_barang', $this->nama_barang);
        $stmt->bindParam(':batch', $this->batch);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':status_payment', $this->status_payment);
        $stmt->bindParam(':status_barang', $this->status_barang);
        $stmt->bindParam(':foto_arrived_wh_kr', $this->foto_arrived_wh_kr);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM $this->table_name WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
