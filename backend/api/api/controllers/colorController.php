<?php
require_once 'models/colorModel.php';


class ColorController
{

    private $color;

    public function __construct()
    {
        $this->color = new Color();
    }

    public function getAll()
    {
        $data = $this->color->getColors();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->color->getColorById($id);
        if ($data == null) {
            $data = "No hay ningun Color con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        $dataCreate = $this->color->createColor($data);

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

        $dataUpdate = $this->color->updateColor($id, $data);
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
        $data = $this->color->deleteColor($id);

        if (!$data) {
            exit(json_encode("No hay ninguna Color"));
        } else {
            exit(json_encode(array('status' => 'success')));
        }
    }

    public function getColoresByArticulo($id){
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->color->getColoresByArticulo($id);
        if (!$data) {
            exit(json_encode("este color no tiene ningun articulo asignado"));
        } else {
            exit(json_encode($data));
        }
    }
}