<?php
require_once 'connection.php';
require_once 'clienteDireccionModel.php';
require_once 'logotipoModel.php';

class Individual
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getIndividual()
    {

        $sql = $this->conn->query("SELECT * FROM cliente_individual");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $direccion = new Direccion();
            $logotipo = new Logotipos;

            foreach ($data as $key => $val) {
                $val->direcciones = $direccion->getDireccionByIndividualId($val->id_individual);
                $_GET["es_empresa"]="false";
                $val->logotipos = $logotipo->getLogotiposByCliente($val->id_individual);
            }
        }

        return $data;
    }

    public function getIndividualById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_individual WHERE id_individual =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data) {
            $direccion = new Direccion();
            $logotipo = new Logotipos;

            $data->direcciones = $direccion->getDireccionByIndividualId($data->id_individual);
            $_GET["es_empresa"]="false";
            $data->logotipos = $logotipo->getLogotiposByCliente($data->id_individual);
        }

        return $data;
    }

    public function createIndividual($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }
        if ($returnColum["es_empresa"]) {
            unset($returnColum["es_empresa"]);
            unset($return["es_empresa"]);
        }

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO cliente_individual (" . $insDataColumn . ") VALUES ('" . $insData . "')");
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
                $return[$key] = $key . " = '" . $val . "'";
            }
            if ($return["es_empresa"]) {
                unset($return["es_empresa"]);
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE cliente_individual SET " . $insData . " WHERE id_individual=" . $id);
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
