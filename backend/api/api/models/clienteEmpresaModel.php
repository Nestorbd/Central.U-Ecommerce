<?php


class Empresa
{
    private $id;
    private $nombre;
    private $CIF;

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

    public function getCIF(){
        return $this->CIF;
    }
    public function setCIF($CIF){
        $this->CIF = $CIF;
    }

    public function getEmpresa($conn)
    {

        $sql = $conn->query("SELECT c.*, e.nombre, e.CIF FROM cliente c JOIN cliente_empresa e 
        on c.id_empresa = e.id");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getEmpresaById($conn,$id)
    {
        $id =  $conn->quote($id);
        $sql = $conn->query("SELECT c.*, e.nombre, e.CIF FROM cliente c join cliente_empresa e on c.id_empresa = e.id WHERE e.id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createEmpresa($conn,$data)
    {
        $sql = $conn->query("INSERT INTO cliente_empresa (nombre, CIF) VALUES ('" . $data->nombre . "','". $data->CIF."')");
        $data = $sql->fetch(PDO::FETCH_OBJ);
        $data = $this->getEmpresaById($conn,$data->id);

        return $data;
    }

    public function updateEmpresa($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_empresa WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $sql = $this->conn->query("UPDATE cliente_empresa SET nombre = '" . $dataNew->nombre . "',  CIF = '" . $dataNew->CIF . "' WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteEmpresa($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_empresa WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM cliente_empresa WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}