<?php



class Connection
{
    private static $dialect;
    private static $host;
    private static $bd;
    private static $user;
    private static $password;

    public function __construct()
    {
        require_once '../config/config.php';
        static::$dialect = $DIALECT;
        static::$host = $HOST;
        static::$bd = $BD;
        static::$user = $USER;
        static::$password = $PASSWORD;
    }

    static public function conexion()
    {
        $dialect = static::$dialect;
        $host = static::$host;
        $bd = static::$bd;
        $user = static::$user;
        $password = static::$password;

        try {
            

            $conn = new PDO($dialect . ':host=' . $host . ';dbname=' . $bd, $user, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
