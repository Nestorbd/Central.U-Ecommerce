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

        public function getIndividual($conn)
    {

        $sql = $conn->query("SELECT c.*, i.nombre, i.apellidos, i.email, i.NIF FROM cliente c JOIN cliente_individual i 
        on c.id_individual = i.id");

        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getIndividualById($conn,$id)
    {
        $id =  $conn->quote($id);
        $sql = $conn->query("SELECT c.*, i.nombre, i.apellidos, i.email, i.NIF FROM cliente c JOIN cliente_individual i on c.id_individual = i.id WHERE i.id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createIndividual($conn,$data)
    {
        $sql = $conn->query("INSERT INTO cliente_individual (nombre, apellidos, email, NIF) VALUES ('" . $data->nombre . "','".$data->apellidos ."','". $data->email ."','". $data->NIF."')");
        $data = $sql->fetch(PDO::FETCH_OBJ);
        $data = $this->getIndividualById($conn,$data->id);

        return $data;
    }

    public function updateIndividual($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_individual WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $sql = $this->conn->query("UPDATE cliente_individual SET nombre = '" . $dataNew->nombre . "', apellidos = '" . $dataNew->apellidos ."', email = '" . $dataNew->email . "', NIF = '" . $dataNew->NIF . "' WHERE id=" . $id);
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
        $sql_get = $this->conn->query("SELECT * FROM cliente_individual WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM cliente_individual WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}
