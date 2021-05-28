<?php
require_once 'connection.php';


class Usuario
{
    public $conn;

    public function __construct()
    {
        $this->connUsuario = Connection::conexionUsuarios();
        $this->conn = Connection::conexion();
    }

    public function getUsuarios()
    {

        $sql = $this->connUsuario->query("SELECT * FROM usuarios");
        $data = $sql->fetchAll(PDO::FETCH_OBJ);

        return $data;
    }

    public function getUsuarioById($id)
    {
        $id =  $this->connUsuario->quote($id);
        $sql = $this->connUsuario->query("SELECT * FROM usuarios WHERE id =" . $id);
        $data = $sql->fetch(PDO::FETCH_OBJ);



        return $data;
    }

    public function getPermiso($usuarioID, $aplicacionID)
    {
        $grupoID = $this->connUsuario->query("SELECT g.id FROM grupos g 
        JOIN usuarios_grupos u_g ON g.id = u_g.grupoID
        WHERE u_g.usuarioID = " . $usuarioID);
        $grupoID = $grupoID->fetch(PDO::FETCH_OBJ);

        $query = "SELECT r.rol FROM roles r INNER JOIN permisos_grupos p ON r.id = p.rolID 
        WHERE p.grupoID = :grupoID AND p.aplicacionID = :aplicacionID";

        $stmt = $this->connUsuario->prepare($query);

        $usuarioID = htmlspecialchars(strip_tags($usuarioID));
        $aplicacionID = htmlspecialchars(strip_tags($aplicacionID));

        $stmt->bindParam(':grupoID', $grupoID->id, PDO::PARAM_INT);
        $stmt->bindParam(':aplicacionID', $aplicacionID, PDO::PARAM_INT);

        $stmt->execute();

        return  $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getCurrentUser()
    {
        print_r($_SESSION);
        if ($_SESSION["activo"]) {
            $usuario = $_SESSION["usuario"];
            $usuario->rol = $_SESSION["rol"];

            return $usuario;
        } else {
            return false;
        }
    }
}
