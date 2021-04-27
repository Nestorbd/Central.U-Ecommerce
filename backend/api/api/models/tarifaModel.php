<?php
require_once 'connection.php';
require_once 'categoriaTarifaModel.php';
require_once 'tipoTarifaModel.php';

class Tarifa
{
    private $id;
    private $nombre;
    private $precio;
    private $fecha_creacion;
    private $fecha_actualizacion;
    private $activo;
    private $id_categoria;
    private $id_tipo;

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

    public function __construct1($id, $nombre, $precio, $fecha_crecion, $fecha_actualizacion, $activo, $id_categoria, $id_tipo)
    {
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->fecha_crecion = $fecha_crecion;
        $this->fecha_actualizacion = $fecha_actualizacion;
        $this->activo = $activo;
        $this->id_categoria = $id_categoria;
        $this->id_tipo = $id_tipo;
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

    public function getPrecio()
    {
        return $this->precio;
    }
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    public function getFechaCreacion()
    {
        return $this->fecha_creacion;
    }
    public function setFechaCreacion($fecha_creacion)
    {
        $this->fecha_creacion = $fecha_creacion;
    }

    public function getFechaActualizacion()
    {
        return $this->fecha_actualizacion;
    }
    public function setFechaActualizacion($fecha_actualizacion)
    {
        $this->fecha_actualizacion = $fecha_actualizacion;
    }

    public function getactivo()
    {
        return $this->activo;
    }
    public function setactivo($activo)
    {
        $this->activo = $activo;
    }

    public function getIdCategoria()
    {
        return $this->id_categoria;
    }
    public function setIdCategoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
    }

    public function getIdTipo()
    {
        return $this->id_tipo;
    }
    public function setIdTipo($id_tipo)
    {
        $this->id_tipo = $id_tipo;
    }


    public function getTarifa()
    {

        $sql = $this->conn->query("SELECT * FROM tarifas");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if($data){
            $categoria = new CategoriaTarifa;
            $tipo = new TipoTarifa;

            foreach($data as $key => $val){
                $val->categoria = $categoria->getCategoriaById($val->id_categoria);
                $val->tipo = $tipo->getTipoById($val->id_tipo);

                unset($val->id_categoria);
                unset($val->id_tipo);
                unset($val->categoria->tipos);
            }
        }

        return $data;
    }

    public function getTarifaById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM tarifas WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if($data){
            $categoria = new CategoriaTarifa;
            $tipo = new TipoTarifa;

            $data->categoria = $categoria->getCategoriaById($data->id_categoria);
            $data->tipo = $tipo->getTipoById($data->id_tipo);

            unset($data->id_categoria);
            unset($data->id_tipo);
            unset($data->categoria->tipos);

        }

        return $data;
    }

    public function createTarifa($data)
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

        $this->conn->query("INSERT INTO tarifas (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateTarifa($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM tarifas WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE tarifas SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteTarifa($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM tarifas WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM tarifas WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getPrecioAnterior($id){
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM update_precio WHERE id_tarifa = ".$id." ORDER BY precio_actualizacion_tarifa desc LIMIT 1");
        $data = $sql->fetch(PDO::FETCH_OBJ);

        return $data;
    }
    public function getPreciosAnteriores($id){
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM update_precio WHERE id_tarifa = ".$id." ORDER BY precio_actualizacion_tarifa desc");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getTarifasByPedido($id_pedido){
        $id_pedido = $this->conn->quote($id_pedido);
        $sql = $this->conn->query("SELECT t.* FROM tarifas t JOIN pedidos_tarifas p_t ON t.id = p_t.id_tarifa WHERE p_t.id_pedido = ".$id_pedido);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getTarifasByCategoriaAndTipo($data){
        $sql = $this->conn->query("SELECT * FROM tarifas WHERE id_categoria=".$data->id_categoria." AND id_tipo=".$data->id_tipo);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}