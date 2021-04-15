<?php
require_once 'C:\xampp\htdocs\api\api\models\clienteModel.php';
require_once 'C:\xampp\htdocs\api\api\models\clienteIndividualModel.php';
require_once 'C:\xampp\htdocs\api\api\models\clienteEmpresaModel.php';




Class clienteController{

    private $cliente;

public function __construct(){
    $this->cliente = new Cliente();
}

    public function getAll(){
        
        $data = $this->cliente->getCliente();

        exit(json_encode($data));
    }

    public function getOne($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->cliente->getClienteById($id);
        if ($data == null) {
            $data = "No hay ningun logotipo";
         }
         exit(json_encode($data));
}

public function insert(){
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->cliente->createCliente($data);

    if ($dataCreate) {
        exit(json_encode(array('status' => 'success')));
    } else {
        exit(json_encode(array('status' => 'error')));
    }

}

public function update($id){
    if(is_array($id)){
        $id = implode('', $id);
    }
        $data = json_decode(file_get_contents("php://input"));

        $dataUpdate = $this->logotipo->updateLogotipos($id, $data);
        if ($dataUpdate) {
            $this->getOne($id);
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }

    public function delete($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
                $data = $this->logotipo->deleteLogotipos($id);

        if (!$data) {
            exit(json_encode("No hay ningun logotipo"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }
}
