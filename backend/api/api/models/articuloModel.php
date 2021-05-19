<?php
require_once 'connection.php';
require_once 'tallaModel.php';
require_once 'colorModel.php';
require_once 'categoriaArticuloModel.php';


class Articulo
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getArticulos()
    {

        $sql = $this->conn->query("SELECT * FROM articulos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $talla = new Talla;
            $color = new Color;
            $categoria = new CategoriaArticulo;


            foreach ($data as $key => $values) {
                $values->categoria = $categoria->getCategoriaById($values->id_categoria);
                $values->tallas = $talla->getTallasByArticulo($values->id);
                $values->colores = $color->getColoresByArticulo($values->id);


                unset($values->id_categoria);
            }
        }

        return $data;
    }

    public function getArticuloById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM articulos WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data) {
            $talla = new Talla;
            $color = new Color;
            $categoria = new CategoriaArticulo;

            $data->categoria = $categoria->getCategoriaById($data->id_categoria);
            $data->tallas = $talla->getTallasByArticulo($data->id);
            $data->colores = $color->getColoresByArticulo($data->id);

            unset($data->id_categoria);
        }


        return $data;
    }

    public function createArticulo($data, $img)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if (!empty($val)) {
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }

        if ($img) {
            $img = str_replace("C:" . DS . "xampp" . DS . "htdocs" . DS, "http://localhost/", $img);
            $img = str_replace(DS, '/', $img);
            $return["imagen"] = $img;
            $returnColum["imagen"] = "imagen";
        }

        $return["activo"] = 1;
        $returnColum["activo"] = "activo";

        $tallas = $return["tallas"];
        $colores = $return["colores"];

        unset($return["tallas"]);
        unset($returnColum["tallas"]);
        unset($return["colores"]);
        unset($returnColum["colores"]);

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
        $sql = $this->conn->query("SELECT a.* FROM articulos a JOIN talla_articulo t_a ON a.id = t_a.id_articulo WHERE t_a.id_talla =" . $id . " AND t_a.activo = true");
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
        $sql = $this->conn->query("SELECT a.* FROM articulos a JOIN color_articulo c_a ON a.id = c_a.id_articulo WHERE c_a.id_color =" . $id . " AND c_a.activo = true");
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
        if (is_array($data)) {
            $id_articulo = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $exist = $this->conn->query("SELECT * FROM talla_articulo WHERE id_articulo =" . $id_articulo . " AND id_talla =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO talla_articulo (id_articulo, id_talla, activo) values (" . $id_articulo . "," . $key . ", true)");
                }
            }
        } else {
            $id_articulo = $data->id;
            foreach ($data->tallas as $key) {
                $exist = $this->conn->query("SELECT * FROM talla_articulo WHERE id_articulo =" . $id_articulo . " AND id_talla =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO  talla_articulo (id_articulo, id_talla, activo) values (" . $id_articulo . "," . $key . ", true)");
                }
            }
        }

        return true;
    }
    public function añadirColores($data)
    {
        if (is_array($data)) {
            $id_articulo = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $exist = $this->conn->query("SELECT * FROM color_articulo WHERE id_articulo =" . $id_articulo . " AND id_color =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO color_articulo (id_articulo, id_color, activo) values (" . $id_articulo . "," . $key . ", true)");
                }
            }
        } else {
            $id_articulo = $data->id;
            foreach ($data->colores as $key) {
                $exist = $this->conn->query("SELECT * FROM color_articulo WHERE id_articulo =" . $id_articulo . " AND id_color =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO  color_articulo (id_articulo, id_color, activo) values (" . $id_articulo . "," . $key . ", true)");
                }
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

        $sql = $this->conn->query("UPDATE color_articulo SET activo = False WHERE id_articulo=" . $data->id . " AND id_color=" . $data->id_color);

        return $sql;
    }

    public function activarTalla($data)
    {

        $sql = $this->conn->query("UPDATE talla_articulo SET activo = True WHERE id_articulo=" . $data->id . " AND id_talla=" . $data->id_talla);

        return $sql;
    }

    public function activarColor($data)
    {

        $sql = $this->conn->query("UPDATE color_articulo SET activo = True WHERE id_articulo=" . $data->id . " AND id_color=" . $data->id_color);

        return $sql;
    }

    public function getArticulosByPatron($id_patron)
    {

        $sql = $this->conn->query("SELECT  p_a.id_Articulo,
         a.nombre, a.codigo_barra, a.imagen, a.id_categoria,
         p_a.id_color, 
         p_a.id_talla,  
         p_a.cantidad
        FROM patron_articulo p_a 
        JOIN articulos a ON a.id = p_a.id_articulo
        JOIN color c ON c.id = p_a.id_color
        JOIN talla t ON t.id = p_a.id_talla
        WHERE id_patron = '.$id_patron.'");

        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
