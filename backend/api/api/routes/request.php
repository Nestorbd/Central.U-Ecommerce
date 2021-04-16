<?php

class Request
{
    private $controlador;
    private $metodo;
    private $argumento;

    public function __construct()
    {
        if (isset($_GET['url'])) {
            $ruta = $_GET['url'];
            $ruta = explode("/", $ruta);
            $ruta = array_filter($ruta);

            $this->controlador = strtolower(array_shift($ruta));
            $this->metodo = strtolower(array_shift($ruta));
            $this->argumento = $ruta;

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if ((!$this->metodo && !$this->argumento) || ($this->metodo == "ver" && !$this->argumento)) {
                    $this->metodo = "getAll";
                } else {
                    if($this->metodo == "ver"){
                        $this->metodo = "getOne";
                    }
                    // else {
                    //     exit("Este no es el metodo adecuado");
                    // }
                    if($this->controlador == "direccion" && $this->metodo == "cliente"){
                        $this->metodo = "getAllDireccionForOneCliente";
                    }
                    
                }
            } else {
                if (!$this->metodo) {
                    exit("Falta el metodo necesario para ejecutar esta función");
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($this->metodo == "insertar" || ($this->controlador == "formulario" && $this->metodo == "insertarcolumna")) {
                    if($this->metodo == "insertar"){
                        $this->metodo = "insert";
                    }else{
                        $this->metodo = "createColumn";
                    }
                    
                } else {
                    print $this->metodo;
                    exit("Este no es el metodo adecuado");
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                if ($this->metodo == "actualizar") {
                    $this->metodo = "update";
                } else {
                    exit("Este no es el metodo adecuado");
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                if ($this->metodo == "eliminar") {
                    $this->metodo = "delete";
                } else {
                    exit("Este no es el metodo adecuado");
                }
            }
        }
    }

    public function getControlador()
    {
        return $this->controlador;
    }
    public function getMetodo()
    {
        return $this->metodo;
    }
    public function getArgumento()
    {
        return $this->argumento;
    }
}
