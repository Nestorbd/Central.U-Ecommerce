<?php
require_once 'connection.php';


class Logotipos 
{
    private $id;
    private $nombre;
    private $imagen_png;
    private $imagen_svg;
    private $id_individual;
    private $id_empresa;

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

    public function __construct1($id, $nombre, $imagen_png, $imagen_svg, $id_empresa,$id_individual){
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->imagen_png = $imagen_png;
        $this->imagen_svg = $imagen_svg;
        $this->id_individual = $id_individual;
        $this->id_empresa = $id_empresa;
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

    public function getImagenPNG(){
        return $this->imagen_png;
    }
    public function setImagenPNG($imagen_png){
        $this->imagen_png = $imagen_png;
    }

    public function getImagenSVG(){
        return $this->imagen_svg;
    }
    public function setImagenSVG($imagen_svg){
        $this->imagen_svg = $imagen_svg;
    }

    public function getIdEmpresa(){
        return $this->id_empresa;
    }
    public function setIdEmpresa($id_empresa){
        $this->id_empresa = $id_empresa;
    }

    public function getIdIndividual(){
        return $this->id_individual;
    }
    public function setIdIndividual($id_individual){
        $this->id_individual = $id_individual;
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
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key;
            $return[$key] = $val;
        }
        if ($img){
            $return["imagen_png"] = $img;
            $returnColum["imagen_png"] = "imagen_png";
        }
        unset($return["id"]);
        unset($returnColum["id"]);
        
        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO logotipos (".$insDataColumn.") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();
        
        return $data;
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

    public function getLogotiposByCliente($id){
        $id = $this->conn->quote($id);
        if($_GET["es_empresa"] === "true"){
            $sql_get = $this->conn->query("SELECT * FROM logotipos WHERE id_empresa=" . $id);
            $data = $sql_get->fetchAll(PDO::FETCH_OBJ);
        }else{
            $sql_get = $this->conn->query("SELECT * FROM logotipos WHERE id_individual=" . $id);
            $data = $sql_get->fetchAll(PDO::FETCH_OBJ);
        }

        return $data;
    }
}
