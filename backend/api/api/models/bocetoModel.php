<?php
require_once 'connection.php';


class Boceto
{
    private $id;
    private $imagen;
    private $id_pedido;


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

    public function __construct1($id, $imagen, $id_pedido)
    {
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->$imagen = $imagen;
        $this->id_pedido = $id_pedido;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getImagen()
    {
        return $this->imagen;
    }
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function getIdPedido()
    {
        return $this->id_pedido;
    }
    public function setIdPedido($id_pedido)
    {
        $this->id_pedido = $id_pedido;
    }

    public function getBocetos()
    {

        $sql = $this->conn->query("SELECT * FROM bocetos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getBocetoById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM bocetos WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }

    public function createBoceto($data, $img)
    {
        
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key;
            $return[$key] = $val;
        }

        if ($img) {
            $img = str_replace("C:" . DS . "xampp" . DS . "htdocs" . DS, "http://localhost/", $img);
            $img = str_replace(DS, '/', $img);
            $return["imagen"] = $img;
            $returnColum["imagen"] = "imagen";
        }

        unset($return["id"]);
        unset($returnColum["id"]);

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO bocetos (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function deleteBoceto($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM bocetos WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM bocetos WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getBocetosByPedido($id_pedido){
        $id_pedido = $this->conn->quote($id_pedido);
        $sql = $this->conn->query("SELECT * FROM bocetos WHERE id_pedidos=" . $id_pedido);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}