<?php



class Connection
{

    public function __construct()
    {
        $this->conexion();
    }

    static public function conexion()
    {
        try {
            require_once '../config/config.php';

            $conn = new PDO($DIALECT . ':host=' . $HOST . ';dbname=' . $BD, $USER, $PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
