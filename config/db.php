<?php

class db
{
    private $host = "localhost";
    private $db_name = "web-pos";
    //   private $username="root";
    private $username = "root";
    private $password = "rp19970520";
    //   private $password="mysql";

    private $connection;

    public function getConnection()
    {
        $this->connection = null;
        try {

            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->connection->exec("set names UTF8");

        } catch (PDOException $exception) {
            echo "Contact Admin !" . $exception->getMessage();
        }
        return $this->connection;
    }

    public function IUD($sql)
    {
        if ($this->connection == null) {
            $this->getConnection();
        }
        $stamnet = $this->connection->prepare($sql);
        $stamnet->execute();
    }

    public function Search($sql)
    {
        if ($this->connection == null) {
            $this->getConnection();
        }
        $stamnet = $this->connection->prepare($sql);
        $stamnet->execute();
        return $stamnet;
    }
}
