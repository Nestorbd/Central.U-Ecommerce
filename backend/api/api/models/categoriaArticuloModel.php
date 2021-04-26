<?php
require_once 'connection.php';


class CategoriaArticulo
{
    private $id;
    private $nombre;
    private $activo;


    public $conn;

    public function __construct()
    {
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_constructor = '__construct' . $num_params;
        if (method_exists($this, $funcion_constructor)) {
            call_user_func_array(array($this, $funcion_constructor), $params);
        }
    }

    public function __construct0()
    {
        $this->conn = Connection::conexion();
    }

    public function __construct1($id, $nombre, $activo)
    {
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->$nombre = $nombre;
        $this->activo = $activo;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getActivo()
    {
        return $this->activo;
    }
    public function setActivo($activo)
    {
        $this->activo = $activo;
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
            $returnColum[$key] = $key;
            $return[$key] = $val;
        }
        $return["activo"] = 1;
        $returnColum["activo"] = "activo";

        unset($return["id"]);
        unset($returnColum["id"]);

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
