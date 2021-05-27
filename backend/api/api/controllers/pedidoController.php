<?php
require_once 'models/pedidoModel.php';


class PedidoController
{

    private $pedido;

    public function __construct()
    {
        $this->pedido = new Pedido();
    }

    public function getAll()
    {
        $data = $this->pedido->getPedidos();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->pedido->getPedidoById($id);
        if ($data == null) {
            $data = "No hay ningun pedido con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->pedido->createPedido($data);

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

        $dataUpdate = $this->pedido->updatePedido($id, $data);
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
        $data = $this->pedido->deletePedido($id);

        if (!$data) {
            exit(json_encode("No hay ningun pedido"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function añadirLogotipos(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->pedido->añadirLogotipos($data);

        if ($añadir) {
            $this->getOne($data->id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function añadirUsuario(){
        $data = json_decode(file_get_contents("php://input"));
        $añadir = $this->pedido->añadirUsuario($data);

        if ($añadir) {
            $this->getOne($data->id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function getPedidosByUsuario($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data_get = $this->pedido->getPedidosByUsuario($id);

        if (!$data_get) {
            exit(json_encode(array('status'=>"error")));
        } else {
            exit(json_encode($data_get));
        }
    }

    public function validarPedido($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->pedido->validarPedido($id);

        if ($data) {
            $this->getOne($id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

}