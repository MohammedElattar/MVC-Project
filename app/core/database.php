<?php

class db
{
    private static $conn;
    private static $PDO;
    function __construct()
    {
        try {
            self::$PDO = new PDO("mysql:host=" . HOST . ";dbname=" . DB_NAME, USER, PASS);
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$PDO->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function get_instance()
    {
        if (!isset(self::$conn)) {
            self::$conn = new db();
        }
        return self::$conn;
    }
    public function read(string $query, array $data = [], bool $returnResults = false, bool $rowCount = true)
    {
        /**
         * Select Function is used to make announcement in our database 
         * 
         * @param string $query -> is the query string that we use to search
         * 
         * @param array  $data  -> Data we want to pass
         * 
         * @return array #result-> Fetched Data 
         */
        $results = [];

        $stmt = self::$PDO->prepare($query);
        $stmt->execute($data);

        if ($returnResults)
            $results[] = $stmt->fetchAll();

        if ($rowCount)
            $results[] = $stmt->rowCount();

        return $results;
    }
    public function write(string $query, array $data = [])
    {
        /**
         * Write Function is used to modify columns or add data to our tables
         * 
         * @param string $query -> is the query string that we use to search
         * 
         * @param Array  $data  -> Data we want to pass
         */

        $stmt = self::$PDO->prepare($query);
        $stmt->execute($data);
    }
    public function remove(string $checkQuery, array $checkData, string $deleteQuery, array $deleteData)
    {
        /* Delete Function */
        /**
         * @param string $checkQuery to read first if the node is already exists in DB
         * 
         * @param array $checkData Data passed to the read function to check user existence
         * 
         * @param string $deleteQuery Query to delete the node from DB
         * 
         * @param array  $deleteData  data passed to delete function
         * 
         * @return array $res Results After Deltetion Operatoin
         */

        $res = [];
        if ($this->read($checkQuery, $checkData)[0]) {
            $stmt = self::$PDO->prepare($deleteQuery, $deleteData);
            $stmt->execute($checkData);
            $res['success'] = '1';
        } else $res['not-found'] = '1';
        return $res;
    }
}
$db = db::get_instance();
