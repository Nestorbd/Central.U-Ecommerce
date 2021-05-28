<?php
require_once 'models/usuarioModel.php';


class UsuarioController
{

    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function getAll()
    {
        $data = $this->usuario->getUsuarios();

        exit(json_encode($data));
    }

    public function getOne($id)
    {
        if (is_array($id)) {
            $id = implode('', $id);
        }
        $data = $this->usuario->getUsuarioById($id);
        if ($data == null) {
            $data = "No hay ningun usuario con id=" . $id;
            exit(json_encode($data));
        }else{
            $data_r[0] = $data;
            exit(json_encode($data_r));
        }
        
    }

    public function getCurrentUser(){
     $user = $this->usuario->getCurrentUser();
        if($user){
            exit(json_encode($user));
        }else{

            exit(json_encode(array('status' => 'error')));
        }

    }
}