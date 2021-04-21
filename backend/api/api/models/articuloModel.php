<?php
require_once 'connection.php';
require_once 'tallaModel.php';
require_once 'colorModel.php';


class Articulo
{
    private $id;
    private $nombre;
    private $codigo_barra;
    private $stock;
    private $activo;
    private $id_categoria;

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

    public function __construct1($id, $nombre, $codigo_barra, $stock, $activo, $id_categoria)
    {
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->$nombre = $nombre;
        $this->codigo_barra = $codigo_barra;
        $this->stock = $stock;
        $this->activo = $activo;
        $this->id_categoria = $id_categoria;
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

    public function getCodigoBarra()
    {
        return $this->codigo_barra;
    }
    public function setCodigoBarra($codigo_barra)
    {
        $this->codigo_barra = $codigo_barra;
    }

    public function getStock()
    {
        return $this->stock;
    }
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getActivo()
    {
        return $this->activo;
    }
    public function setActivo($activo)
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

    public function getArticulos()
    {

        $sql = $this->conn->query("SELECT * FROM articulos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        $talla = new Talla;
        $color = new Color;


        foreach ($data as $key => $values) {
            $tallas = $talla->getTallasByArticulo($values->id);
            $colores = $color->getColoresByArticulo($values->id);
            
            $values->tallas = $tallas;
            $values->colores = $colores;
        }


        return $data;
    }

    public function getArticuloById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM articulos WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        $talla = new Talla;
        $color = new Color;

        $tallas = $talla->getTallasByArticulo($data->id);
        $colores = $color->getColoresByArticulo($data->id);
        $data->tallas = $tallas;
        $data->colores = $colores;

        return $data;
    }

    public function createArticulo($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key;
            $return[$key] = $val;
        }
        $return["activo"] = 1;

        $tallas = $return["tallas"];
        $colores = $return["colores"];

        unset($return["tallas"]);
        unset($returnColum["tallas"]);
        unset($return["colores"]);
        unset($returnColum["colores"]);

        unset($return["id"]);
        unset($returnColum["id"]);

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO articulos (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();
        $tallas["id"] = $data;
        $colores["id"] = $data;

        $this->añadirTallas($tallas);
        $this->añadirColores($colores);

        return $data;
    }

    public function updateArticulo($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM articulos WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE articulos SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteArticulo($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM articulos WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM articulos WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getArticulosByTalla($id)
    {
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT a.* FROM articulos a JOIN talla_articulo t_a ON a.id = t_a.id_articulo WHERE t_a.id_talla =".$id." AND t_a.activo = true");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        $talla = new Talla;
        $color = new Color;

        foreach ($data as $key => $values) {
            $tallas = $talla->getTallasByArticulo($values->id);
            $colores = $color->getColoresByArticulo($values->id);
            
            $values->tallas = $tallas;
            $values->colores = $colores;
        }

        return $data;
    }

    public function getArticulosByColor($id)
    {
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("SELECT a.* FROM articulos a JOIN color_articulo c_a ON a.id = c_a.id_articulo WHERE c_a.id_color =".$id." AND c_a.activo = true");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        $talla = new Talla;
        $color = new Color;

        foreach ($data as $key => $values) {
            $tallas = $talla->getTallasByArticulo($values->id);
            $colores = $color->getColoresByArticulo($values->id);
            
            $values->tallas = $tallas;
            $values->colores = $colores;
        }

        return $data;
    }

    public function añadirTallas($data)
    {
        if(is_array($data)){
            $id_articulo = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $this->conn->query("Insert into talla_articulo (id_articulo, id_talla, activo) values (" . $id_articulo . "," . $key . ", true)");
            }
            
        }else{
            $id_articulo = $data->id;
            foreach ($data->tallas as $key) {
                $this->conn->query("Insert into talla_articulo (id_articulo, id_talla, activo) values (" . $id_articulo . "," . $key . ", true)");
            }
        }
        


        return true;
    }
    public function añadirColores($data)
    {
        if(is_array($data)){
            $id_articulo = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $this->conn->query("Insert into color_articulo (id_articulo, id_color, activo) values (" . $id_articulo . "," . $key . ", true)");
            }
        }else{
            $id_articulo = $data->id;
            foreach ($data->colores as $key) {
                $this->conn->query("Insert into color_articulo (id_articulo, id_color, activo) values (" . $id_articulo . "," . $key . ", true)");
            }
        }


        return true;
    }

    public function desactivarTalla($data)
    {

        $sql = $this->conn->query("UPDATE talla_articulo SET activo = False WHERE id_articulo=" . $data->id . " AND id_talla=" . $data->id_talla);

        return $sql;
    }

    public function desactivarColor($data)
    {

        $sql = $this->conn->query("UPDATE color_articulo SET activo = False WHERE id_articulo=" . $data->id. " AND id_color=" . $data->id_color);

        return $sql;
    }

    public function activarTalla($data)
    {

        $sql = $this->conn->query("UPDATE talla_articulo SET activo = True WHERE id_articulo=" . $data->id . " AND id_talla=" . $data->id_talla);

        return $sql;
    }

    public function activarColor($data)
    {

        $sql = $this->conn->query("UPDATE color_articulo SET activo = True WHERE id_articulo=" . $data->id. " AND id_color=" . $data->id_color);

        return $sql;
    }
}
