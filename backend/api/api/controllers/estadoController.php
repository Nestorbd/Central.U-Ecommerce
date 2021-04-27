<?php
require_once 'models/estadoPedidoModel.php';


class EstadoController
{

    private $estado;

    public function __construct()
    {
        $this->estado = new Estado();
    }

    public function getAll()
    {
        $data = $this->estado->getEstados();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->estado->getEstadoById($id);
        if ($data == null) {
            $data = "No hay ningun Estado con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->estado->createEstado($data);

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

        $dataUpdate = $this->estado->updateEstado($id, $data);
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
        $data = $this->estado->deleteEstado($id);

        if (!$data) {
            exit(json_encode("No hay ningun Estado"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }
}