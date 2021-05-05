<?php
require_once 'connection.php';
require_once 'tipoTarifaModel.php';


class CategoriaTarifa
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

        $sql = $this->conn->query("SELECT * FROM tarifas_categorias");

        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        $tipo = new TipoTarifa;

        foreach ($data as $key => $values) {
            $tipos = $tipo->getTiposByCategoria($values->id);

            $values->tipos = $tipos;
        }

        return $data;
    }

    public function getCategoriaById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM tarifas_categorias WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        $tipo = new TipoTarifa;

        $tipos = $tipo->getTiposByCategoria($data->id);
        $data->tipos = $tipos;

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

        $tipos = $return["tipos"];
        unset($return["tipos"]);
        unset($returnColum["tipos"]);

        unset($return["id"]);
        unset($returnColum["id"]);

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO tarifas_categorias (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        $tipos["id"] = $data;

        $this->añadirTipos($tipos);

        return $data;
    }

    public function updateCategoria($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM tarifas_categorias WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE tarifas_categorias SET " . $insData . " WHERE id=" . $id);
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
        $sql_get = $this->conn->query("SELECT * FROM tarifas_categorias WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM tarifas_categorias WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getCategoriasByTipo($id)
    {
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT c.id, c.nombre, c_t.activo FROM tarifas_categorias c JOIN categorias_tipo c_t ON c.id = c_t.id_categoria WHERE c_t.id_tipo = " . $id);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function añadirTipos($data)
    {
        if (is_array($data)) {
            $id_categoria = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $exist = $this->conn->query("SELECT * FROM categorias_tipo WHERE id_categoria =" . $id_categoria . " AND id_tipo =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO categorias_tipo (id_categoria, id_tipo, activo) values (" . $id_categoria . "," . $key . ", true)");
                }
            }
        } else {
            $id_categoria = $data->id;
            foreach ($data->tipos as $key) {
                $exist = $this->conn->query("SELECT * FROM categorias_tipo WHERE id_categoria =" . $id_categoria . " AND id_tipo =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO categorias_tipo (id_categoria, id_tipo, activo) values (" . $id_categoria . "," . $key . ", true)");
                }
            }
        }

        return true;
    }

    public function desactivarTipo($data)
    {

        $sql = $this->conn->query("UPDATE categorias_tipo SET activo = False WHERE id_categoria=" . $data->id . " AND id_tipo=" . $data->id_tipo);

        return $sql;
    }

    public function activarTipo($data)
    {

        $sql = $this->conn->query("UPDATE categorias_tipo SET activo = True WHERE id_categoria=" . $data->id . " AND id_tipo=" . $data->id_tipo);

        return $sql;
    }
}
