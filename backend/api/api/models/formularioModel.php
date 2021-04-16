<?php
require_once 'connection.php';


class Formulario 
{
    private $id;
    private $apartado;
    private $label;
    private $placeholder;
    private $value;
    private $type;
    private $formControlName;

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

    public function __construct1($id, $apartado, $label, $placeholder, $value, $type, $formControlName){
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->apartado = $apartado;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->type = $type;
        $this->formControlName = $formControlName;
    }
    public function getId(){
        return $this->id;
    }
    public function setId($id){
        $this->id = $id;
    }

    public function getApartado(){
        return $this->apartado;
    }
    public function setNombre($apartado){
        $this->apartado = $apartado;
    }

    public function getLabel(){
        return $this->label;
    }
    public function setLabel($label){
        $this->label = $label;
    }

    public function getPlaceholder(){
       return $this->placeholder; 
    }
    public function setPlaceholder($placeholder){
        $this->placeholder = $placeholder;
    }

    public function getValue(){
        return $this->value;
    }
    public function setValue($value){
        $this->value = $value;
    }

    public function getType(){
        return $this->type;
    }
    public function setType($type){
        $this->type = $type;
    }

    public function getFormControlName(){
        return $this->formControlName;
    }
    public function setFormControlName($formControlName){
        $this->formControlName = $formControlName;
    }

    public function getFormulario()
    {

        $sql = $this->conn->query("SELECT * FROM formulario");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getFormularioById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM formulario WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createFormulario($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key; 
            $return[$key] = $val;
        }
        
        if(!$return["activo"]){
            $return["activo"]=1;
        }
        $insData= implode("','",$return);
        $insDataColumn = implode(",",$returnColum);

        $sql = $this->conn->query("INSERT INTO formulario (".$insDataColumn.") VALUES ('".$insData."')");

        return $sql;
    }

    public function updateFormulario($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM formulario WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key. " = '".$val."'";
            }
            $insData=implode(", ",$return);

            $sql = $this->conn->query("UPDATE formulario SET ".$insData. " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteFormulario($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM formulario WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM formulario WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function createColumn($data)
    {

        $return = array();
        foreach ($data as $key => $val) {
            $return[$key] = $val;
        }
        if($return['default']){
            $return['default'] = "default '".$return['default']."'";
        }
        $insData= implode("\n",$return);

        $sql = $this->conn->query("Alter table formulario add ".$insData);
        if($sql){
            return true;
        }else{
            return false;
        }
    }
}