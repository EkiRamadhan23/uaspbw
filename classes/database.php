<?php
class database
{
    private $host = 'localhost';
    private $db_name = 'web_users'; // Sesuaikan dengan nama database Anda
    private $username = 'root';  // Sesuaikan dengan username database Anda
    private $password = '';  // Sesuaikan dengan password database Anda
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}