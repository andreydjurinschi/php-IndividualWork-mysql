<?php

namespace database;

require_once('dbConfig.php');

class databaseConnector{
    private $serverName;
    private $user;
    private $password;
    private $dbName;
    private $connection;

    public function __construct(){
        $this->serverName = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASS;
        $this->dbName = DB_NAME;
    }

    /**
     * @throws \dbConnectException
     */
    public function createConnection(){
        try{
            $connection = new \PDO("mysql:host=$this->serverName;dbname=$this->dbName", $this->user, $this->password);
            $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            throw new \dbConnectException("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(){
        return $this->connection;
    }
}