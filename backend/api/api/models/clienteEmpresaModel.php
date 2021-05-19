<?php
require_once 'connection.php';
require_once 'clienteDireccionModel.php';
require_once 'logotipoModel.php';

class Empresa
{
    private $conn;


    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getEmpresa()
    {

        $sql = $this->conn->query("SELECT * FROM  cliente_empresa");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $direccion = new Direccion;
            $logotipo = new Logotipos;

            foreach ($data as $key => $val) {
                $val->direcciones = $direccion->getDireccionByEmpresaId($val->id_empresa);
                $_GET["es_empresa"]="true";
                $val->logotipos = $logotipo->getLogotiposByCliente($val->id_empresa);
            }
        }

        return $data;
    }

    public function getEmpresaById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente_empresa WHERE id_empresa=" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data) {
            $direccion = new Direccion();
            $logotipo = new Logotipos;

            $data->direcciones = $direccion->getDireccionByEmpresaId($data->id_empresa);
            $_GET["es_empresa"]="true";
                $data->logotipos = $logotipo->getLogotiposByCliente($data->id_empresa);
        }

        return $data;
    }

    public function createEmpresa($data)
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

        $this->conn->query("INSERT INTO cliente_empresa (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateEmpresa($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente_empresa WHERE id_empresa=" . $id);
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

            $sql = $this->conn->query("UPDATE cliente_empresa SET " . $insData . " WHERE id_empresa=" . $id);
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
        $sql_get = $this->conn->query("SELECT * FROM cliente_empresa WHERE id_empresa=" . $id);
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
