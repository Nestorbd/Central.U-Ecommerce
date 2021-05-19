<?php
require_once 'connection.php';


class Estado
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getEstados()
    {

        $sql = $this->conn->query("SELECT * FROM estado_pedido");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getEstadoById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM estado_pedido WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createEstado($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }
        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO estado_pedido (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateEstado($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM estado_pedido WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE estado_pedido SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteEstado($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM estado_pedido WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM estado_pedido WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}