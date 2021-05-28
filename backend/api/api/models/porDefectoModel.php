<?php
require_once 'connection.php';


class PorDefecto
{

    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getPorDefectos()
    {

        $sql = $this->conn->query("SELECT * FROM por_defecto");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getPorDefectoById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM por_defecto WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createPorDefecto($data, $img)
    {
        
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key;
            $return[$key] = $val;
        }

        if ($img) {
            $img = str_replace("/var/www/html/", "http://192.168.0.90/", $img);
            $img = str_replace(DS, '/', $img);
            $return["imagen"] = $img;
            $returnColum["imagen"] = "imagen";
        }

        $return["activo"] = 1;
        $returnColum["activo"] = "activo";

        unset($return["id"]);
        unset($returnColum["id"]);

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO por_defecto (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function deletePorDefecto($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM por_defecto WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM por_defecto WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}