<?php
require_once 'models/tipoTarifaModel.php';


class tipoController
{

    private $tipo;

    public function __construct()
    {
        $this->tipo = new tipoTarifa();
    }

    public function getAll()
    {
        $data = $this->tipo->getTipos();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->tipo->getTipoById($id);
        if ($data == null) {
            $data = "No hay ningun tipo con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->tipo->createTipo($data);

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

        $dataUpdate = $this->tipo->updateTipo($id, $data);
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
        $data = $this->tipo->deleteTipo($id);

        if (!$data) {
            exit(json_encode("No hay ninguna tipo"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getTiposByCategoria($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->tipo->getTiposByCategoria($id);
        if (!$data) {
            exit(json_encode("esta tipo no tiene ningun articulo asignado"));
        } else {
            exit(json_encode($data));
        }
    }
}