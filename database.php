<?php
    /*Database Class: Database Connectivity
    * You can use your own or custom PDO wrapper
    */
    class Database
    {
        private $host;
        private $dbName;
        private $userName;
        private $password;
        private $conn;
        private $dbType;
        private $table;
        private $where;
        private $columns;
        public const MYSQL = "MYSQL";
        public const POSTGRE = "POSTGRE";

        function __construct($host, $dbName, $userName, $password, $dbType) {
            $this->host = $host;
            $this->dbName = $dbName;
            $this->userName = $userName;
            $this->password = $password;
            $this->dbType = $dbType;
        }

        public function connect() {
            $this->conn = null;
            try {
                if($this->dbType == Database::MYSQL) {
                    $dataConnection = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->userName, $this->password);
                } else if($this->dbType == Database::POSTGRE) {
                    $dataConnection = new PDO('pgsql:host=' . $this->host . ';dbname=' . $this->dbName, $this->userName, $this->password);
                } else {
                    return false;
                }

                $this->conn = $dataConnection;
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                return false;
            }
        }

        function set_table($table) {
            $this->table = $table;
        }

        function set_where($where) {
            $this->where = $where;
        }

        function set_column($columns) {
            $this->columns = $columns;
        }

        public function find() {
            $sql = "SELECT ".$this->columns." FROM ".$this->table;
            $result = $this->conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $result->execute($this->where);
            return $result->fetchObject();
        }

        public function findAll() {
            $sql = "SELECT ".$this->columns." FROM ".$this->table;
            $result = $this->conn->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
            $result->execute($this->where);
            return $result->fetchAll();
        }

        function __destruct() {
            $this->conn = null;
        }
    }
?>