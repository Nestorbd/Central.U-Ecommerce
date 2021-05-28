<?php
require_once 'connection.php';

class Articulo
{
    public $conn;

    public function __construct()
    {
        $this->connArticulo = Connection::conexionArticulos();
        $this->conn = Connection::conexion();
    }

    public function getArticulos()
    {

        $sql = $this->connArticulo->query("SELECT * FROM articulos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if($data){
            foreach($data as $key => $val){
                if(!isset($val->imagen)){
                    $val->imagen = null;
                }
                $val->ref = $val->articulo . "." . $val->color . "." . $val->talla;
            }
        }

        return $data;
    }

    public function getArticuloById($id)
    {
        $id =  $this->connArticulo->quote($id);
        $sql = $this->connArticulo->query("SELECT * FROM articulos WHERE ID_ARTICULO =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if($data){
            if(!isset($data->imagen)){
                $data->imagen = null;
            }
            $data->ref = $data->articulo . "." . $data->color . "." . $data->talla;
        }

        return $data;
    }


    public function getArticulosByPatron($id_patron)
    {
        
        $sql = $this->conn->query("SELECT  *
        FROM patron_articulo WHERE id_patron=". $id_patron);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
