<?php
require_once 'connection.php';


class Talla
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getTallas()
    {

        $sql = $this->conn->query("SELECT * FROM talla");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getTallaById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM talla WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createTalla($data)
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

        $this->conn->query("INSERT INTO talla (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateTalla($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM talla WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE talla SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteTalla($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM talla WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM talla WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getTallasByArticulo($id){
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT t.id, t.nombre, t_a.activo FROM talla t JOIN talla_articulo t_a ON t.id = t_a.id_talla WHERE t_a.id_articulo = ".$id);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
