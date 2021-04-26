<?php
require_once 'models/clienteIndividualModel.php';
require_once 'models/clienteEmpresaModel.php';




class ClienteController
{

    private $cliente;

    public function __construct()
    {
        // $this->cliente = new Cliente();
    }

    public function getAll()
    {
        $data = array();

        $this->cliente = new Empresa;
        $dataEmpresa = $this->cliente->getEmpresa();

      //  $data["Empresas"] = $dataEmpresa;

        $this->cliente = new Individual;
        $dataIndividual = $this->cliente->getIndividual();
      //  $data["Individuales"] = $dataIndividual;

        array_push($data, $dataEmpresa, $dataIndividual);
        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $isEmpresa = $_GET["es_empresa"];
        if( $isEmpresa === "true") {
            $this->cliente = new Empresa;
            $data = $this->cliente->getEmpresaById($id);
            if ($data == null) {
                $data = "No hay ningun cliente";
                exit(json_encode($data));
            } else {
               $data_r[0] = $data;
               exit(json_encode($data_r));
            }
            
        } else {
            $this->cliente = new Individual;
            $data = $this->cliente->getIndividualById($id);
            if ($data == null) {
                $data = "No hay ningun cliente";
                exit(json_encode($data));
            } else {
                $data_r[0] = $data;
                exit(json_encode($data_r));
            }
            
        }
    }

    public function insert()
    {
        $data = json_decode(file_get_contents("php://input"));
        if ($data->es_empresa === true) {
            $this->cliente = new Empresa;
            $dataCreate = $this->cliente->createEmpresa($data);

            if ($dataCreate) {
                $_GET["es_empresa"] = "true";
                $this->getOne($dataCreate);
            } else {
                exit(json_encode(array('status' => 'error')));
            }
        } else {
            $this->cliente = new Individual;
            $dataCreate = $this->cliente->createIndividual($data);

            if ($dataCreate) {
                $this->getOne($dataCreate);
            } else {
                exit(json_encode(array('status' => 'error')));
            }
        }
    }

    public function update($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = json_decode(file_get_contents("php://input"));

        if ($data->es_empresa === true) {
            $this->cliente = new Empresa;
            $dataCreate = $this->cliente->updateEmpresa($id, $data);

            if ($dataCreate) {
                exit(json_encode(array('status' => 'success')));
            } else {
                exit(json_encode(array('status' => 'error')));
            }
        } else {
            $this->cliente = new Individual;
            $dataCreate = $this->cliente->updateIndividual($id, $data);

            if ($dataCreate) {
                exit(json_encode(array('status' => 'success')));
            } else {
                exit(json_encode(array('status' => 'error')));
            }
        }
    }

    public function delete($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = json_decode(file_get_contents("php://input"));
        if($data->es_empresa === true)
        {
            $this->cliente = new Empresa;
            $data = $this->cliente->deleteEmpresa($id);
            if (!$data) {
                exit(json_encode(array('status' => 'error')));
            } else {
                exit(json_encode(array('status' => 'success')));
            }
        }else{
            $this->cliente = new Individual;
            $data = $this->cliente->deleteIndividual($id);
            if (!$data) {
                exit(json_encode(array('status' => 'error')));
            } else {
                exit(json_encode(array('status' => 'success')));
            }
        }
        


    }
}
