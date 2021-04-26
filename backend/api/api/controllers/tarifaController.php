<?php
require_once 'models/tarifaModel.php';


Class TarifaController{

    private $tarifa;

public function __construct(){
    $this->tarifa = new Tarifa();
}

    public function getAll(){
        
        $data = $this->tarifa->getTarifa();

        exit(json_encode($data));
    }

    public function getOne($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->tarifa->getTarifaById($id);
        if ($data == null) {
            $data = "No hay ningun tarifa con id=".$id;
            exit(json_encode($data));
         }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
         }
         
}

public function insert(){
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->tarifa->createTarifa($data);

    if ($dataCreate) {
        $this->getOne($dataCreate);
    } else {
        exit(json_encode(array('status' => 'error')));
    }

}

public function update($id){
    if(is_array($id)){
        $id = implode('', $id);
    }
        $data = json_decode(file_get_contents("php://input"));

        $dataUpdate = $this->tarifa->updateTarifa($id, $data);
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
                $data = $this->tarifa->deleteTarifa($id);

        if (!$data) {
            exit(json_encode("No hay ninguna tarifa con id= ".$id));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getPrecioAnterior($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->tarifa->getPrecioAnterior($id);

        if (!$data) {
            exit(json_encode("No hay ninguna tarifa con id= ".$id));
        } else {
            exit(json_encode($data));
        }
    }
    public function getPreciosAnteriores($id){
        if(is_array($id)){
            $id = implode('', $id);
        }
        $data = $this->tarifa->getPreciosAnteriores($id);

        if (!$data) {
            exit(json_encode("No hay ninguna tarifa con id= ".$id));
        } else {
            exit(json_encode($data));
        }
    }
}