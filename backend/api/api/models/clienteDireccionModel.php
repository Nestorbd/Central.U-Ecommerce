<?php


class Direccion
{
    private $id;
    private $calle;
    private $numero;
    private $municipio;
    private $provincia;
    private $codigo_postal;
    private $id_individual;
    private $id_empresa;


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

    public function getCalle(){
        return $this->calle;
    }
    public function setCalle($calle){
        $this->calle = $calle;
    }

    public function getNumero(){
        return $this->numero;
    }
    public function setNumero($numero){
        $this->numero = $numero;
    }

    public function getMunicipio(){
        return $this->municipio;
    }
    public function setMunicipio($municipio){
        $this->municipio = $municipio;
    }

    public function getProvincia(){
        return $this->provincia;
    }
    public function setProvincia($provincia){
        $this->provincia = $provincia;
    }

    public function getCodigoPostal(){
        return $this->codigo_postal;
    }
    public function setCodigoPostal($codigo_postal){
        $this->codigo_postal = $codigo_postal;
    }

    public function getIdIndividual(){
        return $this->id_individual;
    }
    public function setIdIndividual($id_individual){
        $this->id_individual = $id_individual;
    }

    public function getIdEmpresa(){
        return $this->id_empresa;
    }
    public function setIdEmpresa($id_empresa){
        $this->id_empresa = $id_empresa;
    }

    public function getDireccion()
    {

        $sql = $this->conn->query("SELECT * FROM  cliente_direccion");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getDireccionById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_direccion WHERE id=". $id);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getDireccionByIndividualId($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_direccion WHERE id_individual=". $id);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
    public function getDireccionByEmpresaId($id)
    {
        print_r($id);
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_direccion WHERE id_empresa=". $id);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
    public function createDireccion($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key; 
            $return[$key] = $val;
        }
        $insData= implode("','",$return);
        $insDataColumn = implode(",",$returnColum);

        $sql = $this->conn->query("INSERT INTO cliente_direccion (".$insDataColumn.") VALUES ('".$insData."')");

        return $sql;
    }

    public function updateDireccion($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_direccion WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key. " = '".$val."'";
            }
            $insData=implode(", ",$return);

            $sql = $this->conn->query("UPDATE cliente_direccion SET ".$insData. " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteDireccion($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_direccion WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM cliente_direccion WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}