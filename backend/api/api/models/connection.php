<?php



class Connection
{
    private static $dialect;
    private static $host;
    private static $bd;
    private static $bd_articulos;
    private static $bd_usuarios;
    private static $user;
    private static $password;

    public function __construct($DIALECT,$HOST,$BD,$BD_ARTICULOS,$BD_USUARIOS,$USER,$PASSWORD)
    {
        static::$dialect = $DIALECT;
        static::$host = $HOST;
        static::$bd = $BD;
        static::$bd_articulos = $BD_ARTICULOS;
        static::$bd_usuarios = $BD_USUARIOS;
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

    static public function conexionArticulos()
    {
        $dialect = static::$dialect;
        $host = static::$host;
        $bd = static::$bd_articulos;
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

    static public function conexionUsuarios()
    {
        $dialect = static::$dialect;
        $host = static::$host;
        $bd = static::$bd_usuarios;
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
