<?php
require_once 'models/formularioModel.php';


Class FormularioController{

    private $formulario;

public function __construct(){
    $this->formulario = new Formulario();
}

    public function getAll(){
        
        $data = $this->formulario->getFormulario();

        exit(json_encode($data));
    }

    public function getOne($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->formulario->getFormularioById($id);
        if ($data == null) {
            $data = "No hay ningun formulario con id=".$id;
         }
         exit(json_encode($data));
}

public function insert(){
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->formulario->createFormulario($data);

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

        $dataUpdate = $this->formulario->updateFormulario($id, $data);
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
                $data = $this->formulario->deleteFormulario($id);

        if (!$data) {
            exit(json_encode("No hay ningun logotipo"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function createColumn(){
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->formulario->createColumn($data);

        if ($dataCreate) {
            exit(json_encode(array('status' => 'success')));
        } else {
            exit(json_encode(array('status' => 'error')));
        }
    }
}