<?php

namespace otaviocipriano\phpframephork\core;

use PDO;
use PDOException;

class Db{
    private string $server;
    private string $name;
    private string $host;
    private string $user;
    private string $pass;

    protected mixed $conn;

    function __construct()
    {
        $env = new Env();
        $this->server = $_ENV['DB_SERVER'];
        $this->name = $_ENV['DB_NAME'];
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];
    }

    public function connect(){
        try {
            $this->conn = new PDO("$this->server:host=$this->host;dbname=$this->name", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
            
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function get_connect(){
        return $this->conn;
    }

    public function disconnect(){
        return $this->conn = null;
    }
}