<?php
require_once 'connection.php';


class Logotipos 
{
    private $id;
    private $nombre;
    private $imagen;
    public $conn;

    public function __construct()
	{
		$params = func_get_args();
		$num_params = func_num_args();
		$funcion_constructor ='__construct'.$num_params;
		if (method_exists($this,$funcion_constructor)) {
			call_user_func_array(array($this,$funcion_constructor),$params);
		}
	}

    public function __construct0(){
        $this->conn = Connection::conexion();
    }

    public function __construct1($id, $nombre, $imagen){
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->imagen = $imagen;
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getImagen(){
        return $this->imagen;
    }
    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function getLogotipos()
    {

        $sql = $this->conn->query("SELECT * FROM logotipos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getLogotiposById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM logotipos WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createLogotipos($data, $img)
    {
        $sql = $this->conn->query("INSERT INTO logotipos (nombre, imagen) VALUES ('" . $data->nombre . "','".$img."')");

        return $sql;
    }

    public function updateLogotipos($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM logotipos WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $sql = $this->conn->query("UPDATE logotipos SET nombre = '" . $dataNew->nombre . "'  WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteLogotipos($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM logotipos WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM logotipos WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}
