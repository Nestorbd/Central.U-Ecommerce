<?php
require_once 'models/tallaModel.php';


class TallaController
{

    private $talla;

    public function __construct()
    {
        $this->talla = new talla();
    }

    public function getAll()
    {
        $data = $this->talla->getTallas();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->talla->getTallaById($id);
        if ($data == null) {
            $data = "No hay ningun talla con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->talla->createTalla($data);

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

        $dataUpdate = $this->talla->updateTalla($id, $data);
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
        $data = $this->talla->deleteTalla($id);

        if (!$data) {
            exit(json_encode("No hay ninguna talla"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getTallasByArticulo($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->talla->getTallasByArticulo($id);
        if (!$data) {
            exit(json_encode("esta talla no tiene ningun articulo asignado"));
        } else {
            exit(json_encode($data));
        }
    }
}