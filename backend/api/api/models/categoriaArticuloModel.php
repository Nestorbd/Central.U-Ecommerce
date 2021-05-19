<?php
require_once 'connection.php';


class CategoriaArticulo
{
    public $conn;


    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getCategorias()
    {

        $sql = $this->conn->query("SELECT * FROM articulo_categoria");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getCategoriaById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM articulo_categoria WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createCategoria($data)
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

        $this->conn->query("INSERT INTO articulo_categoria (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateCategoria($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM articulo_categoria WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE articulo_categoria SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteCategoria($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM articulo_categoria WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM articulo_categoria WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}
