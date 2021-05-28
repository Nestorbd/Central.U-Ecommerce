<?php
require_once 'connection.php';
require_once 'clienteEmpresaModel.php';
require_once 'clienteIndividualModel.php';


class Logotipos 
{
    public $conn;

    public function __construct(){
        $this->conn = Connection::conexion();
    }

    public function getLogotipos()
    {

        $sql = $this->conn->query("SELECT * FROM logotipos");
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

    public function getLogotiposById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM logotipos WHERE id =" . $id);
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

    public function createLogotipos($data, $img)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }
        if ($img){
            $img = str_replace("/var/www/html/", "http://192.168.0.90/", $img);
            $img = str_replace(DS,'/',$img);
            $return["imagen_png"] = $img;
            $returnColum["imagen_png"] = "imagen_png";
        }
        
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
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE logotipos SET ".$insData."  WHERE id=" . $id);
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

    public function getLogotiposByPedido($id_pedido){
        $id_pedido = $this->conn->quote($id_pedido);
        $sql = $this->conn->query("SELECT l.* FROM logotipos l JOIN logotipos_pedido l_p ON l.id = l_p.id_logotipos WHERE l_p.id_pedidos = ".$id_pedido);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
