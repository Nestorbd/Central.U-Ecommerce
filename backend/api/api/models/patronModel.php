<?php
require_once 'connection.php';
require_once 'articuloModel.php';
require_once 'tarifaModel.php';


class Patron
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getPatrones()
    {

        $sql = $this->conn->query("SELECT * FROM patron");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {

            $articulo = new Articulo();
            $tarifa = new Tarifa();

            foreach ($data as $key => $val) {
                $val->articulos = $articulo->getArticulosByPatron($val->id);
                $val->tarifas = $tarifa->getTarifasByPatron($val->id);
            }
        }

        return $data;
    }

    public function getPatronById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM patron WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data) {
            $articulo = new Articulo();
            $tarifa = new Tarifa();

            $data->articulos = $articulo->getArticulosByPatron($data->id);
            $data->tarifas = $tarifa->getTarifasByPatron($data->id);
        }

        return $data;
    }

    public function createPatron($data, $img)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if (!empty($val)) {
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }

        $articulo["cantidad"] = $return["cantidad"];
        $articulo["id_articulo"] = $return["id_articulo"];
        $tarifas = $return["tarifas"];

        unset($return["cantidad"]);
        unset($returnColum["cantidad"]);

        unset($return["id_articulo"]);
        unset($returnColum["id_articulo"]);

        unset($return["tarifas"]);
        unset($returnColum["tarifas"]);

        if ($img) {
            $img = str_replace("/var/www/html/", "http://192.168.0.90/", $img);;
            $img = str_replace(DS, '/', $img);
            $return["imagen"] = $img;
            $returnColum["imagen"] = "imagen";
        }

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);
        $this->conn->query("INSERT INTO patron (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastINSERTId();

        $articulo["id_patron"] = $data;
        $tarifas["id_patron"] = $data;

        $this->añadirArticulos($articulo);
        $this->añadirTarifas($tarifas);

        return $data;
    }

    public function updatePatron($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM patron WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE patron SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deletePatron($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM patron WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM patron WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function añadirArticulos($data)
    {
        if (is_array($data)) {
            $id_patron = $data['id_patron'];
            $id_articulo = $data['id_articulo'];

                $exist = $this->conn->query("SELECT * FROM patron_articulo WHERE id_patron =" . $id_patron . " AND id_articulo =" . $id_articulo);
                $exist = $exist->fetch();
                if (!$exist) {
                    $sql = $this->conn->query("INSERT INTO patron_articulo (id_patron, id_articulo, cantidad) VALUES (" . $id_patron . "," . $id_articulo . "," . $data["cantidad"] . ")");
                }
            return true;
        } else {
            $id_patron = $data->id_patron;
            $id_articulo = $data->id_articulo;

                $exist = $this->conn->query("SELECT * FROM patron_articulo WHERE id_patron =" . $id_patron . " AND id_articulo =" . $id_articulo);
                $exist = $exist->fetch();
                if (!$exist) {
                    $sql =  $this->conn->query("INSERT INTO patron_articulo (id_patron, id_articulo, cantidad) VALUES (" . $id_patron . "," . $id_articulo . "," . $data->cantidad . ")");
                }
            
            return true;
        }
    }

    public function añadirTarifas($data)
    {
        if (is_array($data)) {
            $id_patron = $data['id_patron'];
            unset($data["id_patron"]);
            foreach ($data as $key) {
                $exist = $this->conn->query("SELECT * FROM patron_tarifa WHERE id_patron =" . $id_patron . " AND id_tarifa =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $sql =   $this->conn->query("INSERT INTO patron_tarifa (id_tarifa, id_patron) VALUES (" . $key . "," . $id_patron . ")");
                }
            }
            return true;
        } else {
            $id_patron = $data->id_patron;
            foreach ($data->tarifas as $key) {
                $exist = $this->conn->query("SELECT * FROM patron_tarifa WHERE id_patron =" . $id_patron . " AND id_tarifa =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $sql =  $this->conn->query("INSERT INTO patron_tarifa (id_tarifa, id_patron) VALUES (" . $key . "," . $id_patron . ")");
                }
            }
            return true;
        }
    }

    public function quitarArticulos($data)
    {

        $id_patron = $data->id_patron;
        $id_articulo = $data->id_articulo;
        foreach ($data->variantes as $key => $val) {
            $exist = $this->conn->query("SELECT * FROM patron_articulo WHERE id_patron =" . $id_patron . " AND id_articulo =" . $id_articulo);
            $exist = $exist->fetch();
            if ($exist) {
                $sql =  $this->conn->query("DELETE FROM patron_articulo WHERE id_patron = " . $id_patron . " AND id_articulo =" . $id_articulo);
            }
        }
        return true;
    }

    public function quitarTarifas($data)
    {
        $id_patron = $data->id_patron;
        foreach ($data->tarifas as $key) {
            $exist = $this->conn->query("SELECT * FROM patron_tarifa WHERE id_patron =" . $id_patron . " AND id_tarifa =" . $key);
            $exist = $exist->fetch();
            if ($exist) {
                $sql =  $this->conn->query("DELETE FROM patron_tarifa WHERE id_patron = " . $id_patron . " AND id_tarifa = " . $key);
            }
        }
        return true;
    }

    public function getPatronesByPedido($id_pedido)
    {
        $sql = $this->conn->query("SELECT id,imagen,observaciones FROM patron WHERE id_pedido =" . $id_pedido);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {

            $articulo = new Articulo();
            $tarifa = new Tarifa();

            foreach ($data as $key => $val) {
                $val->articulos = $articulo->getArticulosByPatron($val->id);
                $val->tarifas = $tarifa->getTarifasByPatron($val->id);
            }
        }

        return $data;
    }
}
