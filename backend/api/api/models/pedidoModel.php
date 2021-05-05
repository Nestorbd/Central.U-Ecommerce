<?php
require_once 'connection.php';
require_once 'articuloModel.php';
require_once 'logotipoModel.php';
require_once 'tarifaModel.php';
require_once 'usuarioModel.php';
require_once 'bocetoModel.php';
require_once 'estadoPedidoModel.php';
require_once 'clienteEmpresaModel.php';
require_once 'clienteIndividualModel.php';


class Pedido
{
    private $id;
    private $firma_cliente;
    private $parte_trabajo;
    private $fecha_terminacion;
    private $observaciones;
    private $validado;
    private $id_individual;
    private $id_empresa;
    private $id_estado;

    public $conn;

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
    }

    public function __construct1($id, $firma_cliente, $parte_trabajo, $fecha_terminacion, $observaciones, $validado, $id_individual, $id_empresa, $id_estado)
    {
        $this->conn = Connection::conexion();
        $this->id = $id;
        $this->$firma_cliente = $firma_cliente;
        $this->parte_trabajo = $parte_trabajo;
        $this->fecha_terminacion = $fecha_terminacion;
        $this->observaciones = $observaciones;
        $this->validado = $validado;
        $this->id_individual = $id_individual;
        $this->id_empresa = $id_empresa;
        $this->id_estado = $id_estado;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFirmaCliente()
    {
        return $this->firma_cliente;
    }
    public function setFirmaCliente($firma_cliente)
    {
        $this->firma_cliente = $firma_cliente;
    }

    public function getParteTrabajo()
    {
        return $this->parte_trabajo;
    }
    public function setParteTrabajo($parte_trabajo)
    {
        $this->parte_trabajo = $parte_trabajo;
    }

    public function getFechaTerminacion()
    {
        return $this->fecha_terminacion;
    }
    public function setFechaTerminacion($fecha_terminacion)
    {
        $this->fecha_terminacion = $fecha_terminacion;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function getValidado()
    {
        return $this->validado;
    }
    public function setValidado($validado)
    {
        $this->validado = $validado;
    }

    public function getIdIndividual()
    {
        return $this->id_individual;
    }
    public function setIdIndividual($id_individual)
    {
        $this->id_individual = $id_individual;
    }

    public function getIdEmpresa()
    {
        return $this->id_empresa;
    }
    public function setIdEmpresa($id_empresa)
    {
        $this->id_empresa = $id_empresa;
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }
    public function setIdEstado($id_estado)
    {
        $this->id_estado = $id_estado;
    }


    public function getPedidos()
    {

        $sql = $this->conn->query("SELECT * FROM pedidos");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $logotipo = new Logotipos;
            $tarifa = new Tarifa;
            $articulo = new Articulo;
            $boceto = new Boceto;
            $estado = new Estado;

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
                $val->tarifas = $tarifa->getTarifasByPedido($val->id);
                $val->articulos = $articulo->getArticulosByPedido($val->id);
                $val->bocetos = $boceto->getBocetosByPedido($val->id);
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
            $tarifa = new Tarifa;
            $articulo = new Articulo;
            $boceto = new Boceto;
            $estado = new Estado;

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
            $data->tarifas = $tarifa->getTarifasByPedido($data->id);
            $data->articulos = $articulo->getArticulosByPedido($data->id);
            $data->bocetos = $boceto->getBocetosByPedido($data->id);
        }


        return $data;
    }

    public function createPedido($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            $returnColum[$key] = $key;
            $return[$key] = $val;
        }

        $logotipos = $return["logotipos"];
        $articulos = $return["articulos"];
        $tarifas = $return["tarifas"];
        $usuario["id_usuario"] = $return["id_usuario"];
        $usuario["id_estado"] = $return["id_estado"];

        unset($return["logotipos"]);
        unset($returnColum["logotipos"]);

        unset($return["articulos"]);
        unset($returnColum["articulos"]);

        unset($return["tarifas"]);
        unset($returnColum["tarifas"]);

        unset($return["id"]);
        unset($returnColum["id"]);

        unset($return["id_usuario"]);
        unset($returnColum["id_usuario"]);

        if (empty($return["id_individual"])) {
            unset($return["id_individual"]);
            unset($returnColum["id_individual"]);
        } else {
            unset($return["id_empresa"]);
            unset($returnColum["id_empresa"]);
        }

        $return["validado"] = 0;

        if (empty($return["esta_firmado"]) || $return["esta_firmado"] === "false") {
            $return["esta_firmado"] = 0;
        } else {
            $return["esta_firmado"] = 1;
        }

        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO pedidos (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        $logotipos["id"] = $data;
        $articulos["id"] = $data;
        $tarifas["id"] = $data;
        $usuario["id"] = $data;

        $this->añadirLogotipos($logotipos);
        $this->añadirArticulos($articulos);
        $this->añadirTarifas($tarifas);
        $this->añadirUsuario($usuario);


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

            if (empty($return["esta_firmado"]) || $return["esta_firmado"] === "false") {
                $return["esta_firmado"] = 0;
            } else {
                $return["esta_firmado"] = 1;
            }

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
                    $this->conn->query("Insert into logotipos_pedido (id_logotipos, id_pedidos) values (" . $key . "," . $id_pedido . ")");
                }
            }
        } else {
            $id_pedido = $data->id;
            foreach ($data->logotipos as $key) {
                $exist = $this->conn->query("SELECT * FROM logotipos_pedido WHERE id_pedidos =" . $id_pedido . " AND id_logotipos =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("Insert into logotipos_pedido (id_logotipos, id_pedidos) values (" . $key . "," . $id_pedido . ")");
                }
            }
        }

        return true;
    }

    public function añadirTarifas($data)
    {
        if (is_array($data)) {
            $id_pedido = $data['id'];
            unset($data["id"]);
            foreach ($data as $key) {
                $exist = $this->conn->query("SELECT * FROM pedidos_tarifas WHERE id_pedido =" . $id_pedido . " AND id_tarifa =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("Insert into pedidos_tarifas (id_tarifa, id_pedido) values (" . $key . "," . $id_pedido . ")");
                }
            }
        } else {
            $id_pedido = $data->id;
            foreach ($data->tarifas as $key) {
                $exist = $this->conn->query("SELECT * FROM pedidos_tarifas WHERE id_pedido =" . $id_pedido . " AND id_tarifa =" . $key);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("Insert into pedidos_tarifas (id_tarifa, id_pedido) values (" . $key . "," . $id_pedido . ")");
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
                $this->conn->query("Insert into usuario_act_pedido (id_usuario, id_pedido, id_estado) values (" . $data["id_usuario"] . "," . $data["id"] . "," . $data["id_estado"] . ")");
            }
        } else {
            $exist = $this->conn->query("SELECT * FROM usuario_act_pedido WHERE id_pedido =" . $data->id . " AND id_usuario =" . $data->id_usuario . " AND id_estado =" . $data->id_estado);
            $exist = $exist->fetch();
            if (!$exist) {
                $this->conn->query("Insert into usuario_act_pedido (id_usuario, id_pedido, id_estado) values (" . $data->id_usuario . "," . $data->id . "," . $data->id_estado . ")");
            }
        }

        return true;
    }

    public function añadirArticulos($data)
    {
        if (is_array($data)) {
            $id_pedido = $data['id'];
            unset($data["id"]);
            foreach ($data as $key => $val) {
                $exist = $this->conn->query("SELECT * FROM articulos_pedidos WHERE id_pedidos =" . $id_pedido . " AND id_articulo =" . $val->id_articulo . " AND id_talla =" . $val->id_talla . " AND id_color =" . $val->id_color);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("Insert into articulos_pedidos (id_pedidos, id_articulo, id_talla, id_color, cantidad) values (" . $id_pedido . "," . $val->id_articulo . "," . $val->id_talla . "," . $val->id_color . "," . $val->cantidad . ")");
                }
            }
        } else {
            $id_pedido = $data->id;
            foreach ($data->articulos as $key => $val) {
                $exist = $this->conn->query("SELECT * FROM articulos_pedidos WHERE id_pedidos =" . $id_pedido . " AND id_articulo =" . $val->id_articulo . " AND id_talla =" . $val->id_talla . " AND id_color =" . $val->id_color);
                $exist = $exist->fetch();
                if (!$exist) {
                    $this->conn->query("Insert into articulos_pedidos (id_pedidos, id_articulo, id_talla, id_color, cantidad) values (" . $id_pedido . "," . $val->id_articulo . "," . $val->id_talla . "," . $val->id_color . "," . $val->cantidad . ")");
                }
            }
        }

        return true;
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
