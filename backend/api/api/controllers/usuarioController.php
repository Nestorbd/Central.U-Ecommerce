<?php
require_once 'models/usuarioModel.php';


class UsuarioController
{

    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function getAll()
    {
        $data = $this->usuario->getUsuarios();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->usuario->getUsuarioById($id);
        if ($data == null) {
            $data = "No hay ningun usuario con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->usuario->createUsuario($data);

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

        $dataUpdate = $this->usuario->updateUsuario($id, $data);
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
        $data = $this->usuario->deleteUsuario($id);

        if (!$data) {
            exit(json_encode("No hay ningun usuario"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getUsuariosByPedido($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data_get = $this->usuario->getUsuariosByPedido($id);

        if (!$data_get) {
            exit(json_encode("este usuario no tiene asignado ningun pedido"));
        } else {
            exit(json_encode($data_get));
        }
    }
}