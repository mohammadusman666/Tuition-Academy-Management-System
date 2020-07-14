<?php
class DB
{
    private $pdo;

    public function __construct($host, $dbname, $username, $password)
    {
        try
        { 
            $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        catch (PDOException $e)
        {
            die ("Connection Failed: " . $e->getMessage());
        }
    }

    public function query($query, $params = array())
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        if (explode(' ', $query)[0] == 'SELECT')
        {
            $data = $statement->fetchAll();
            return $data;
        }
    }
}