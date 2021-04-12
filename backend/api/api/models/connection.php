<?php



class Connection{
    
    // private $dialect = $DIALECT;
    // private $host = $HOST;
    // private $bd = $BD;
    // private $user = $USER;
    // private $password = $PASSWORD;

protected function conexion(){
try{      
    require_once '../config/config.php';

    $conn = new PDO($DIALECT.':host='.$HOST.';dbname='.$BD, $USER, $PASSWORD);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
}catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }
  }
