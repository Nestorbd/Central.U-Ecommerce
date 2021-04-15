<?php
require_once 'connection.php';


class Cliente
{
    private $id;
    private $telefono;
    private $es_empresa;
    private $individual;
    private $empresa;

    private $conn;

    public function __construct()
    {
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_constructor = '__construct' . $num_params;
        if (method_exists($this, $funcion_constructor)) {
            call_user_func_array(array($this, $funcion_constructor), $params);
        }
    }

    public function __construct0()
    {
        $this->conn = Connection::conexion();
        $this->individual = new Individual;
        $this->empresa = new Empresa;
    }

    public function __construct1($id, $telefono, $es_empresa)
    {
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->telefono = $telefono;
        $this->es_empresa = $es_empresa;
        $this->individual = new Individual;
        $this->empresa = new Empresa;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getEsEmpresa()
    {
        return $this->es_empresa;
    }
    public function setEsEmpresa($es_empresa)
    {
        $this->es_empresa = $es_empresa;
    }

    public function getIdIndividual()
    {
        return $this->individual;
    }
    public function setIdIndividual($individual)
    {
        $this->individual = $individual;
    }

    public function getIdEmpresa()
    {
        return $this->empresa;
    }
    public function setIdEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    public function getCliente()
    {
        $data = array();
        array_push($data, $this->empresa->getEmpresa($this->conn), $this->individual->getIndividual($this->conn));

        return $data;
    }

    public function getClienteById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM cliente WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data->es_empresa) {
            $data = $this->empresa->getEmpresaById($this->conn, $data->id_empresa);
        } else {
            $data = $this->individual->getIndividualById($this->conn, $data->id_individual);
        }

        return $data;
    }


    public function createCliente($data)
    {
        if ($data->es_empresa) {
            $data_empresa = $this->empresa->createEmpresa($this->conn, $data);
            $sql = $this->conn->query("INSERT INTO cliente (telefono, es_empresa, id_empresa, id_individual) VALUES ('" . $data->telefono . "', True,'" . $data_empresa->id . "',null)");
            $data = $sql->fetch(PDO::FETCH_OBJ);
            if ($data) {
                return true;
            } else {
                return false;
            }
        } else {
            $data_individual = $this->individual->createIndividual($this->conn, $data);
            $sql = $this->conn->query("INSERT INTO cliente (telefono, es_empresa, id_individual, id_empresa) VALUES ('" . $data->telefono . "', False,'" . $data_individual->id . "',null)");
            $data = $sql->fetch(PDO::FETCH_OBJ);
            if ($data) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function createClienteIndividual($data)
    {
        $sql = $this->conn->query("INSERT INTO cliente (telefono, es_empresa, id_individual) VALUES ('" . $data->telefono . "', False,'" . $data->id_individual . "')");

        return $sql;
    }

    public function createClienteEmpresa($data)
    {
        $sql = $this->conn->query("INSERT INTO cliente (telefono, es_empresa, id_empresa) VALUES ('" . $data->telefono . "', True,'" . $data->id_empresa . "')");

        return $sql;
    }

    public function updateCliente($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $sql = $this->conn->query("UPDATE cliente SET telefono = '" . $dataNew->telefono . "' WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteCliente($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM cliente WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM cliente WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }
}
