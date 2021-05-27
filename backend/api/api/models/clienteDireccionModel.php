<?php
require_once 'connection.php';
require_once 'clienteEmpresaModel.php';
require_once 'clienteIndividualModel.php';

class Direccion
{
    private $conn;

    public function __construct(){
        $this->conn = Connection::conexion();
    }

    public function getDireccion()
    {

        $sql = $this->conn->query("SELECT * FROM  cliente_direccion");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if($data){
            foreach($data as $key => $val){
                if($val->id_empresa != null){
                    $cliente = new Empresa;
                    $val->empresa = $cliente->getEmpresaById($val->id_empresa);
                    unset($val->empresa->logotipos);
                    unset($val->empresa->direcciones);
                }else{
                    $cliente = new Individual;
                    $val->individual = $cliente->getIndividualById($val->id_individual);
                    unset($val->individual->logotipos);
                    unset($val->individual->direcciones);
                }
                unset($val->id_empresa);
                unset($val->id_individual);
            }
        }

        return $data;
    }

    public function getDireccionById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_direccion WHERE id=". $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if($data){
            if($data->id_empresa != null){
                $cliente = new Empresa;
                    $data->empresa = $cliente->getEmpresaById($data->id_empresa);
                    unset($data->empresa->logotipos);
                    unset($data->empresa->direcciones);
            }else{
                $cliente = new Individual;
                    $data->individual = $cliente->getIndividualById($data->id_individual);
                    unset($data->individual->logotipos);
                    unset($data->individual->direcciones);
            }
            unset($data->id_empresa);
            unset($data->id_individual);
        }

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
            if(!empty($val)){
                $returnColum[$key] = $key; 
                $return[$key] = $val;
            }
        }
        // if(empty($return["id_individual"])){
        //     unset($return["id_individual"]);
        //     unset($returnColum["id_individual"]);
        // }else{
        //     unset($return["id_empresa"]);
        //     unset($returnColum["id_empresa"]);
        // }
        
        $insData= implode("','",$return);
        $insDataColumn = implode(",",$returnColum);

        $this->conn->query("INSERT INTO cliente_direccion (".$insDataColumn.") VALUES ('".$insData."')");
        $data = $this->conn->lastInsertId();
        
        return $data;
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