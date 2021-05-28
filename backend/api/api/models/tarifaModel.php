<?php
require_once 'connection.php';
require_once 'categoriaTarifaModel.php';
require_once 'tipoTarifaModel.php';

class Tarifa
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
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
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }
        $return["activo"] = 1;
        $returnColum["activo"] = "activo";

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

    public function getTarifasByPatron($id_patron){
        
        $id_patron = $this->conn->quote($id_patron);
        $sql = $this->conn->query("SELECT t.* FROM tarifas t JOIN patron_tarifa p_t ON t.id = p_t.id_tarifa WHERE p_t.id_patron = ".$id_patron);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getTarifasByCategoriaAndTipo($data){
        $sql = $this->conn->query("SELECT * FROM tarifas WHERE id_categoria=".$data->id_categoria." AND id_tipo=".$data->id_tipo);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}