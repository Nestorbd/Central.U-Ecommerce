<?php
require_once 'models/clienteDireccionModel.php';





class DireccionController
{

    private $direccion;

    public function __construct()
    {
        $this->direccion = new Direccion;
    }

    public function getAll()
    {
        $data = $this->direccion->getDireccion();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->direccion->getDireccionById($id);
        if ($data == null) {
            $data = "No hay ningun formulario con id=".$id;
         }
         exit(json_encode($data));
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->direccion->createDireccion($data);

    if ($dataCreate) {
        exit(json_encode(array('status' => 'success')));
    } else {
        exit(json_encode(array('status' => 'error')));
    }
    }

    public function update($id)
    {
        if(is_array($id)){
            $id = implode('', $id);
        }
            $data = json_decode(file_get_contents("php://input"));
    
            $dataUpdate = $this->direccion->updateDireccion($id, $data);
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
        $data = $this->direccion->deleteDireccion($id);

        if (!$data) {
            exit(json_encode(array('status' => 'error')));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getAllDireccionForOneCliente($id){
        if($_GET['es_empresa'] === "true"){
           $data = $this->direccion->getDireccionByEmpresaId($id);
           if (!$data) {
            exit(json_encode(array('status' => 'error')));
        } else {
            exit(json_encode($data));
        }
        }else{
            if($_GET['es_empresa'] === "false"){
                $data = $this->direccion->getDireccionByEmpresaId($id);
                if (!$data) {
                    exit(json_encode(array('status' => 'error')));
                } else {
                    exit(json_encode($data));
                }
            }else{
                exit(json_encode(array('status' => 'error')));
            }
        }

    }
}
