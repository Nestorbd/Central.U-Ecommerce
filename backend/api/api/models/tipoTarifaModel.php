<?php
require_once 'connection.php';


class TipoTarifa
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

    public function getTipos()
    {

        $sql = $this->conn->query("SELECT * FROM tarifas_tipo");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getTipoById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM tarifas_tipo WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createTipo($data)
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

        $this->conn->query("INSERT INTO tarifas_tipo (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateTipo($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM tarifas_tipo WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE tarifas_tipo SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteTipo($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM tarifas_tipo WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM tarifas_tipo WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getTiposByCategoria($id){
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT t.id, t.nombre, c_t.activo FROM tarifas_tipo t JOIN categorias_tipo c_t ON t.id = c_t.id_tipo WHERE c_t.id_categoria = ".$id);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}