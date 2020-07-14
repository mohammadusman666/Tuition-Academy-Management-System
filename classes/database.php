<?php

class DB
{
    // this function is used to connect to the database
    // static means that we can use it without the need to create a DB class object
    private static function connect()
    {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=tuitionacademy;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
    
    // this function executes the query
    // $query = the query you want to run, %params = parameters for that query
    public static function query($query, $params = array())
    {
        $statement = self::connect()->prepare($query); // connects to database and prepares the query
        $statement->execute($params); // executes the query

        if(explode(' ', $query)[0] == 'SELECT')
        {
            $data = $statement->fetchAll(); // gets the data from the query
            return $data; // return the data fetched  
        }
    }

}

?>