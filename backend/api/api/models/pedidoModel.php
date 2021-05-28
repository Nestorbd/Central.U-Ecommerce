<?php
require_once 'connection.php';
require_once 'logotipoModel.php';
require_once 'usuarioModel.php';
require_once 'estadoPedidoModel.php';
require_once 'clienteEmpresaModel.php';
require_once 'clienteIndividualModel.php';
require_once 'patronModel.php';


class Pedido
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getPedidos()
    {

        $sql = $this->conn->query("SELECT * FROM pedidos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $logotipo = new Logotipos;
            $estado = new Estado;
            $patron = new Patron;

            foreach ($data as $key => $val) {

                $val->estado = $estado->getEstadoById($val->id_estado);
                unset($val->id_estado);

                if($val->id_empresa != null){
                    $cliente = new Empresa;
                    $val->empresa = $cliente->getEmpresaById($val->id_empresa);
                    unset($val->empresa->logotipos);
                    unset($val->empresa->direcciones);
                }else{
                    $cliente = new Individual;
                    $val->individual = $cliente->getIndividualById($val->id_individual);
                    unset($val->individual->logotipos);
                    unset($val->individual->direcciones);
                }
                unset($val->id_empresa);
                unset($val->id_individual);

                $val->logotipos = $logotipo->getLogotiposByPedido($val->id);
                $val->patrones = $patron->getPatronesByPedido($val->id);
            }
        }
        return $data;
    }

    public function getPedidoById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM pedidos WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data) {
            $logotipo = new Logotipos;
            $estado = new Estado;
            $patron = new Patron;

            $data->estado = $estado->getEstadoById($data->id_estado);
            unset($data->id_estado);

            if($data->id_empresa != null){
                $cliente = new Empresa;
                    $data->empresa = $cliente->getEmpresaById($data->id_empresa);
                    unset($data->empresa->logotipos);
                    unset($data->empresa->direcciones);
            }else{
                $cliente = new Individual;
                    $data->individual = $cliente->getIndividualById($data->id_individual);
                    unset($data->individual->logotipos);
                    unset($data->individual->direcciones);
            }
            unset($data->id_empresa);
            unset($data->id_individual);

            $data->logotipos = $logotipo->getLogotiposByPedido($data->id);
            $data->patrones = $patron->getPatronesByPedido($data->id);
        }


        return $data;
    }

    public function createPedido($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }

        $logotipos = $return["logotipos"];
        $usuario["id_usuario"] = $return["id_usuario"];
        $usuario["id_estado"] = $return["id_estado"];
        $patrones = $return["patrones"];

        unset($return["logotipos"]);
        unset($returnColum["logotipos"]);

        unset($return["id_usuario"]);
        unset($returnColum["id_usuario"]);

        unset($return["patrones"]);
        unset($returnColum["patrones"]);

        // if (empty($return["id_individual"])) {
        //     unset($return["id_individual"]);
        //     unset($returnColum["id_individual"]);
        // } else {
        //     unset($return["id_empresa"]);
        //     unset($returnColum["id_empresa"]);
        // }

        $return["validado"] = 0;

        if (empty($return["esta_firmado"]) || $return["esta_firmado"] === "false") {
            $return["esta_firmado"] = 0;
        } else {
            $return["esta_firmado"] = 1;
        }

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);
        $this->conn->query("INSERT INTO pedidos (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastINSERTId();

        $logotipos["id"] = $data;
        $usuario["id"] = $data;

        $this->añadirLogotipos($logotipos);
        $this->añadirUsuario($usuario);

        $patron = new Patron();

        foreach ($patrones as $key => $val){

            $data_pedido["id_pedido"] = $data;
            
            $patron->updatePatron($val->id_patron,$data_pedido);
    
        }


        return $data;
    }

    public function updatePedido($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM pedidos WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {

            $usuario["id"] = $id;
            $usuario["id_usuario"] = $dataNew->id_usuario;
            $usuario["id_estado"] = $dataNew->id_estado;

            unset($dataNew->id_usuario);

            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE pedidos SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                $this->añadirUsuario($usuario);
                return true;
            } else {
                return false;
            }
        }
    }

    public function deletePedido($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM pedidos WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM pedidos WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function añadirLogotipos($data)
    {
        if (is_array($data)) {
            $id_pedido = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $exist = $this->conn->query("SELECT * FROM logotipos_pedido WHERE id_pedidos =" . $id_pedido . " AND id_logotipos =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO logotipos_pedido (id_logotipos, id_pedidos) VALUES (" . $key . "," . $id_pedido . ")");
                }
            }
        } else {
            $id_pedido = $data->id;
            foreach ($data->logotipos as $key) {
                $exist = $this->conn->query("SELECT * FROM logotipos_pedido WHERE id_pedidos =" . $id_pedido . " AND id_logotipos =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("INSERT INTO logotipos_pedido (id_logotipos, id_pedidos) VALUES (" . $key . "," . $id_pedido . ")");
                }
            }
        }

        return true;
    }

    public function añadirUsuario($data)
    {
        if (is_array($data)) {
            $exist = $this->conn->query("SELECT * FROM usuario_act_pedido WHERE id_pedido =" . $data["id"] . " AND id_usuario =" . $data["id_usuario"] . " AND id_estado =" . $data["id_estado"]);
            $exist = $exist->fetch();
            if (!$exist) {
                $this->conn->query("INSERT INTO usuario_act_pedido (id_usuario, id_pedido, id_estado) VALUES (" . $data["id_usuario"] . "," . $data["id"] . "," . $data["id_estado"] . ")");
            }
        } else {
            $exist = $this->conn->query("SELECT * FROM usuario_act_pedido WHERE id_pedido =" . $data->id . " AND id_usuario =" . $data->id_usuario . " AND id_estado =" . $data->id_estado);
            $exist = $exist->fetch();
            if (!$exist) {
                $this->conn->query("INSERT INTO usuario_act_pedido (id_usuario, id_pedido, id_estado) VALUES (" . $data->id_usuario . "," . $data->id . "," . $data->id_estado . ")");
            }
        }

        return true;
    }

    public function añadirPatrones($data){
        if (is_array($data)){
            $patron = new Patron();
            $id_pedido = $data['id_pedido'];
            unset($data['id_pedido']);
           foreach($data as $key => $val){
            $val["id_pedido"] = $id_pedido;
            $patron->createPatron($val,null);
           }
        }
    }

    public function getPedidosByUsuario($id_usuario)
    {
        $id_usuario =  $this->conn->quote($id_usuario);
        $sql = $this->conn->query("SELECT p.*, e.nombre AS 'estado' 
        FROM usuario_act_pedido u_p 
        JOIN pedidos p ON p.id = u_p.id_pedido 
        JOIN estado_pedido e ON e.id = u_p.id_estado 
        WHERE u_p.id_usuario = " . $id_usuario);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function validarPedido($id)
    {
        $id = $this->conn->quote($id);
        $sql = $this->conn->query("UPDATE pedidos SET validado = true WHERE id=" . $id);

        return $sql;
    }
}
