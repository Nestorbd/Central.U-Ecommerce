<?php
require_once 'connection.php';


class Individual
{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $NIF;

    private $conn;

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

    public function getApellidos(){
        return $this->apellidos;
    }
    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getNIF(){
        return $this->NIF;
    }
    public function setNIF($NIF){
        $this->NIF = $NIF;
    }

        public function getIndividual()
    {

        $sql = $this->conn->query("SELECT * FROM cliente_individual"); 
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getIndividualById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_individual WHERE id_individual =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createIndividual($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key; 
            $return[$key] = $val;
        }
        if($returnColum["es_empresa"]){
            unset($returnColum["es_empresa"]);
            unset($return["es_empresa"]);
        }

        unset($return["id_individual"]);
        unset($returnColum["id_individual"]);

        $insData= implode("','",$return);
        $insDataColumn = implode(",",$returnColum);

        $this->conn->query("INSERT INTO cliente_individual (".$insDataColumn.") VALUES ('".$insData."')");
        $data = $this->conn->lastInsertId();
        
        return $data;
    }

    public function updateIndividual($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_individual WHERE id_individual=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key. " = '".$val."'";
            }
            if($return["es_empresa"]){
                unset($return["es_empresa"]);
            }
            $insData=implode(", ",$return);

            $sql = $this->conn->query("UPDATE cliente_individual SET ".$insData. " WHERE id_individual=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteIndividual($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_individual WHERE id_individual=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM cliente_individual WHERE id_individual=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}
