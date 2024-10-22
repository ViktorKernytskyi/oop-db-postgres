<?php

//Enable display of errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//echo "hi world" . '<br>';
require_once 'config.php'; // Connecting configurations
class Database {

    private $pdo; // A PDO object for working with the database
    private $table; // The name of the table to work with
    private $select = '*'; // Fields that we choose
    private $params = []; // Parameters for queries

    public function __construct($dsn, $user, $password, $opt)
    {

        $this->connect($dsn, $user, $password, $opt); // We connect to the database when creating a class object
    }

    /**
     * A method of connecting to a database via PDO
     */
    protected function connect($dsn, $user, $password, $opt)
    {
        echo "Configuration file connected successfully!<br>";
        try {
            echo "Trying to connect...<br>";
            // Connecting to a database via PDO
            $this->pdo = new PDO($dsn, $user, $password, $opt);
            echo "The connection to the database is successful!<br>";
        } catch (PDOException $e) {
            // We output an error if something went wrong
            echo "Connection error: " . $e->getMessage() . "<br>";
        }

    }
    /**
     *getPDO() method to get a PDO object
     */
    public function getPDO() {
        return $this->pdo;
    }
    /**
     * Specify the table for operations
     */
    public function table($name)
    {
        $this->table = $name;
        return $this;
    }

    /**
     * We select the fields for the request
     */
    public function select(...$names)
    {
        $this->select = implode(',', $names);
        return $this;
    }

    /**
     * Add WHERE conditions to the query
     */
    public function where($column, $value)
    {
        $this->params[$column] = $value;
        return $this;
    }

    /**
     * We execute a SELECT query and return the result
     */
    public function get()
    {
        $response = [];
        $whereClause = '';

// Form the WHERE part of the request
        if (!empty($this->params)) {
            $conditions = [];
            foreach ($this->params as $column => $value) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $conditions);
        }

// Prepared SQL query
        $sql = "SELECT {$this->select} FROM {$this->table}" . $whereClause;
        $stmt = $this->pdo->prepare($sql);

// We execute a request with parameters
        foreach ($this->params as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(); // We return all results
    }

    /**
     * Method for inserting new data (INSERT)
     */
    public function insert($data)
    {
        // Remove the 'id' key from the array, if it exists
        if (isset($data['id'])) {
            unset($data['id']);
        }
        $columns = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute(); // We execute the request and return the result
    }

    /**
     *Method for updating data (UPDATE)
     */
    public function update($data)
    {
        $setClause = '';
        $conditions = [];

        foreach ($data as $column => $value) {
            $conditions[] = "$column = :$column";
        }
        $setClause = implode(',', $conditions);

        $whereClause = '';
        if (!empty($this->params)) {
            $whereConditions = [];
            foreach ($this->params as $column => $value) {
                $whereConditions[] = "$column = :where_$column";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $whereConditions);
        }

        $sql = "UPDATE {$this->table} SET {$setClause}" . $whereClause;
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        foreach ($this->params as $column => $value) {
            $stmt->bindValue(":where_$column", $value);
        }

        return $stmt->execute(); // We execute the request
    }

    /**
     * Method for deleting data (DELETE)
     */
    public function delete()
    {
        $whereClause = '';
        if (!empty($this->params)) {
            $conditions = [];
            foreach ($this->params as $column => $value) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql = "DELETE FROM {$this->table}" . $whereClause;
        $stmt = $this->pdo->prepare($sql);

        foreach ($this->params as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        return $stmt->execute(); // We execute the request
    }



}

/**
 * @var  $db
 * Creating an object of the Database class
 */
$db = new Database($dsn, $user, $password, $opt);
