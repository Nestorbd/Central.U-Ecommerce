<?php
require_once 'models/categoriaTarifaModel.php';


class CategoriaTarifaController
{

    private $categoria;

    public function __construct()
    {
        $this->categoria = new CategoriaTarifa();
    }

    public function getAll()
    {
        $data = $this->categoria->getCategorias();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->categoria->getCategoriaById($id);
        if ($data == null) {
            $data = "No hay ningun categoria con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->categoria->createCategoria($data);

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

        $dataUpdate = $this->categoria->updateCategoria($id, $data);
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
        $data = $this->categoria->deleteCategoria($id);

        if (!$data) {
            exit(json_encode("No hay ninguna categoria"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getCategoriasByTipo($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->categoria->getCategoriasByTipo($id);
        if (!$data) {
            exit(json_encode("esta categoria no tiene ninguna categoria asignado"));
        } else {
            exit(json_encode($data));
        }
    }

    public function añadirTipos(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->categoria->añadirTipos($data);

        if ($añadir) {
            $this->getOne($data->id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }

    }

    public function desactivarTipo(){
        $data = json_decode(file_get_contents("php://input"));
        $desactivado = $this->categoria->desactivarTipo($data);

        if ($desactivado) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function activarTipo(){
        $data = json_decode(file_get_contents("php://input"));
        $desactivado = $this->categoria->activarTipo($data);

        if ($desactivado) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

}