<?php
require_once 'models/rolUsuarioModel.php';


class RolController
{

    private $rol;

    public function __construct()
    {
        $this->rol = new Rol();
    }

    public function getAll()
    {
        $data = $this->rol->getRols();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->rol->getRolById($id);
        if ($data == null) {
            $data = "No hay ningun rol con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->rol->createRol($data);

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

        $dataUpdate = $this->rol->updateRol($id, $data);
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
        $data = $this->rol->deleteRol($id);

        if (!$data) {
            exit(json_encode("No hay ningun rol"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }
}