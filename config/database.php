<?php

class database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "0713025880";
    private $dbName = "pos_db";
    private $connection;

    public function getConnection()
    {
        $this->connection = new mysqli($this->servername, $this->username, $this->password);
        try {
            try {
                if ($this->connection->select_db($this->dbName) === false) {

                    $sql = "CREATE DATABASE " . $this->dbName;

                    if ($this->connection->query($sql) == TRUE) {

                        $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
                        $this->createAllTable($this->dbName, $this->connection);
                        return $this->connection;
                    }

                }

            } catch (PDOException $e) {
                echo $e->getMessage(), PHP_EOL;
            }

            $this->connection = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->dbName, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->connection->exec("set names UTF8");

            return $this->connection;

        } catch (PDOException $e) {
            echo $e->getMessage(), PHP_EOL;
        }


    }

    public function createAllTable($dbName, $connection)
    {

        $query_file = 'config/sq.sql';

        try {

            $fp = fopen($query_file, 'r');
            $sql = fread($fp, filesize($query_file));
            fclose($fp);

            $connection->select_db($dbName);
            $retval = $connection->multi_query($sql);

            if (!$retval) {
                die('Could not create table: ' . $connection->error());
            }

//            echo "Table created successfully\n";

        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

    public function IUD($sql)
    {
        if ($this->connection == null) {
            $this->getConnection();
        }
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function Search($sql)
    {
        if ($this->connection == null) {
            $this->getConnection();
        }
        $statement = $this->connection->prepare($sql);
        $statement->execute();
        return $statement;
    }

    public function createDatabaseTable()
    {

        $con = $this->getConnection();

    }

}