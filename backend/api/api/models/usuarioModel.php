<?php
require_once 'connection.php';
require_once 'rolUsuarioModel.php';


class Usuario
{
    public $conn;

    public function __construct()
    {
        $this->conn = Connection::conexion();
    }

    public function getUsuarios()
    {

        $sql = $this->conn->query("SELECT * FROM usuario");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        if ($data) {
            $rol = new Rol;

            foreach ($data as $key => $val) {
                $val->rol = $rol->getRolById($val->id_rol);
                unset($val->id_rol);
            }
        }

        return $data;
    }

    public function getUsuarioById($id)
    {
        $id =  $this->conn->quote($id);
        $sql = $this->conn->query("SELECT * FROM usuario WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);

        if ($data) {
            $rol = new Rol;

            $data->rol = $rol->getRolById($data->id_rol);
            unset($data->id_rol);
        }

        return $data;
    }

    public function createUsuario($data)
    {
        $return = array();
        $returnColum = array();

        foreach ($data as $key => $val) {
            if(!empty($val)){
                $returnColum[$key] = $key;
                $return[$key] = $val;
            }
        }
        $return["activo"] = 1;
        $returnColum["activo"] = "activo";
        
        $insData = implode("','", $return);
        $insDataColumn = implode(",", $returnColum);

        $this->conn->query("INSERT INTO usuario (" . $insDataColumn . ") VALUES ('" . $insData . "')");
        $data = $this->conn->lastInsertId();

        return $data;
    }

    public function updateUsuario($id, $dataNew)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM usuario WHERE id=" . $id);
        $dataOld = $sql_get->fetch();
        if ($dataOld == null) {
            return false;
        } else {
            $return = array();

            foreach ($dataNew as $key => $val) {
                $return[$key] = $key . " = '" . $val . "'";
            }
            $insData = implode(", ", $return);

            $sql = $this->conn->query("UPDATE usuario SET " . $insData . " WHERE id=" . $id);
            if ($sql) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function deleteUsuario($id)
    {
        $id = $this->conn->quote($id);
        $sql_get = $this->conn->query("SELECT * FROM usuario WHERE id=" . $id);
        $data = $sql_get->fetch();
        if ($data == null) {
            return false;
        } else {
            $sql = "DELETE FROM usuario WHERE id=" . $id;
            if ($this->conn->query($sql) == TRUE) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getUsuariosByPedido($id_pedido)
    {
        $id_pedido =  $this->conn->quote($id_pedido);
        $sql = $this->conn->query("SELECT u.*, e.nombre FROM usuario_act_pedido u_a_p JOIN usuario u JOIN estado_pedido e 
        ON u.id = u_a_p.id_usuario ON e.id = u_a_p.id_estado WHERE u_a_p.id_pedido = " . $id_pedido);
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }
}
