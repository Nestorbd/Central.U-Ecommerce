<?php
require_once 'connection.php';


class Formulario
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
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
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }
        $return["activo"] = 1;
        $returnColum["activo"] = "activo";

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO formulario (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
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
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE formulario SET " . $insData . " WHERE id=" . $id);
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
        if ($return['default']) {
            $return['default'] = "default '" . $return['default'] . "'";
        }
        $insData = implode("\n", $return);

        $sql = $this->conn->query("Alter table formulario add " . $insData);
        if ($sql) {
            return true;
        } else {
            return false;
        }
    }

    public function getColumns()
    {
        $sql = $this->conn->query("Describe formulario");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);
        $dataFields = array();
        $c = 0;
        foreach ($data as $key => $val) {
         //   $dataFields[$key] = $val;
            foreach ($val as $keyVal => $finalVal)
            if($keyVal === "Field" && $finalVal != "id"){
                $dataFields[$c] = $finalVal;
                $c += 1;
            }
        }

        return $dataFields;
    }
}
