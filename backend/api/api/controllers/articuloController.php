<?php
require_once 'models/articuloModel.php';


class ArticuloController
{

    private $articulo;

    public function __construct()
    {
        $this->articulo = new Articulo();
    }

    public function getAll()
    {

        $data = $this->articulo->getArticulos();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->articulo->getArticuloById($id);
        if ($data == null) {
            $data = "No hay ningun articulo con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0]= $data;
            exit(json_encode($data_r));
        }

        
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->articulo->createArticulo($data);

        if ($dataCreate) {
            $this->getOne($dataCreate);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function update($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = json_decode(file_get_contents("php://input"));

        $dataUpdate = $this->articulo->updateArticulo($id, $data);
        if ($dataUpdate) {
            $this->getOne($id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function delete($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->articulo->deleteArticulo($id);

        if (!$data) {
            exit(json_encode("No hay ningun logotipo"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getArticulosByTalla($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data_get = $this->articulo->getArticulosByTalla($id);

        if (!$data_get) {
            exit(json_encode("este articulo no tiene asignada ninguna talla"));
        } else {
            exit(json_encode($data_get));
        }
    }

    public function getArticulosByColor($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data_get = $this->articulo->getArticulosByColor($id);

        if (!$data_get) {
            exit(json_encode("este articulo no tiene asignada ningun color"));
        } else {
            exit(json_encode($data_get));
        }
    }

    public function añadirTallas(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->articulo->añadirTallas($data);

        if ($añadir) {
            $this->getOne($data->id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }

    }
    public function añadirColores(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->articulo->añadirColores($data);

        if ($añadir) {
            $this->getOne($data->id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }

    }

    public function desactivarTalla(){
        $data = json_decode(file_get_contents("php://input"));
        $desactivado = $this->articulo->desactivarTalla($data);

        if ($desactivado) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function desactivarColor(){
        $data = json_decode(file_get_contents("php://input"));
        $desactivado = $this->articulo->desactivarColor($data);

        if ($desactivado) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function activarTalla(){
        $data = json_decode(file_get_contents("php://input"));
        $desactivado = $this->articulo->activarTalla($data);

        if ($desactivado) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function activarColor(){
        $data = json_decode(file_get_contents("php://input"));
        $desactivado = $this->articulo->activarColor($data);

        if ($desactivado) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }
}
