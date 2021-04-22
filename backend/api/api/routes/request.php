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

            $this->controlador = array_shift($ruta);
            $this->metodo = array_shift($ruta);
            $this->argumento = array_shift($ruta);

            $isCorrectMetod = false;

            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if ((!$this->metodo && !$this->argumento) || ($this->metodo == "ver" && !$this->argumento)) {
                    $this->metodo = "getAll";
                    $isCorrectMetod = true;
                } else {
                    if ($this->metodo == "ver") {
                        $this->metodo = "getOne";
                        $isCorrectMetod = true;
                    }
                    if($this->controlador == "logotipo" && $this->metodo == "cliente"){
                        $this->metodo = "getLogotiposByCliente";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "direccion" && $this->metodo == "cliente") {
                        $this->metodo = "getAllDireccionForOneCliente";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "formulario" && $this->metodo == "verColumnas") {
                        $this->metodo = "getColumns";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "articulo" && $this->metodo == "talla") {
                        $this->metodo = "getArticulosByTalla";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "articulo" && $this->metodo == "color") {
                        $this->metodo = "getArticulosByColor";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "color" && $this->metodo == "articulo") {
                        $this->metodo = "getColoresByArticulo";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "talla" && $this->metodo == "articulo") {
                        $this->metodo = "getTallasByArticulo";
                        $isCorrectMetod = true;
                    }
                    if($this->controlador == "categoriaTarifa" && $this->metodo == "tipo"){
                        $this->metodo = "getCategoriasByTipo";
                        $isCorrectMetod = true;
                    }
                    if($this->controlador == "tipo" && $this->metodo == "categoria"){
                        $this->metodo = "getTiposByCategoria";
                        $isCorrectMetod = true;
                    }
                    if($this->controlador == "tarifa" && $this->metodo == "verPrecioAnterior"){
                        $this->metodo = "getPrecioAnterior";
                        $isCorrectMetod = true;
                    }  
                    if($this->controlador == "tarifa" && $this->metodo == "verPreciosAnteriores"){
                        $this->metodo = "getPreciosAnteriores";
                        $isCorrectMetod = true;
                    }
                }
            }


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($this->metodo == "insertar") {
                    $this->metodo = "insert";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "formulario" && $this->metodo == "insertarColumna") {
                    $this->metodo = "createColumn";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "articulo" && $this->metodo == "agregarTallas") {
                    $this->metodo = "añadirTallas";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "articulo" && $this->metodo == "agregarColores") {
                    $this->metodo = "añadirColores";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "categoriaTarifa" && $this->metodo == "agregarTipos") {
                    $this->metodo = "añadirTipos";
                    $isCorrectMetod = true;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                if ($this->metodo == "actualizar") {
                    
                    $this->metodo = "update";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "articulo" && $this->metodo == "desactivarTalla") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "articulo" && $this->metodo == "desactivarColor") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "articulo" && $this->metodo == "activarTalla") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "articulo" && $this->metodo == "activarColor") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "categoriaTarifa" && $this->metodo == "desactivarTipo") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "categoriaTarifa" && $this->metodo == "activarTipo") {
                    $isCorrectMetod = true;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                if ($this->metodo == "eliminar") {
                    $this->metodo = "delete";
                    $isCorrectMetod = true;
                }
            }
        }

        if ($isCorrectMetod == false) {
            exit("Este metodo no es el adecuado");
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
