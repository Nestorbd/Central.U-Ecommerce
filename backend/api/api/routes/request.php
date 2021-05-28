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
                    if($this->controlador == "logotipo" && $this->metodo == "pedido"){
                        $this->metodo = "getLogotiposByPedido";
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
                    if ($this->controlador == "articulo" && $this->metodo == "patron") {
                        $this->metodo = "getArticulosByPatron";
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
                    if ($this->controlador == "pedido" && $this->metodo == "usuario") {
                        $this->metodo = "getPedidosByUsuario";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "usuario" && $this->metodo == "pedido") {
                        $this->metodo = "getUsuariosByPedido";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "tarifa" && $this->metodo == "pedido") {
                        $this->metodo = "getTarifasByPedido";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "tarifa" && $this->metodo == "categoriaYTipo") {
                        $this->metodo = "getTarifasByCategoriaAndTipo";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "patron" && $this->metodo == "pedido") {
                        $this->metodo = "getPatronesByPedido";
                        $isCorrectMetod = true;
                    }
                    if ($this->controlador == "usuario" && $this->metodo == "actual") {
                        $this->metodo = "getCurrentUser";
                        $isCorrectMetod = true;
                    }
                }
            }


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($this->metodo == "insertar" && $this->controlador != "articulo") {
                    $this->metodo = "insert";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "formulario" && $this->metodo == "insertarColumna") {
                    $this->metodo = "createColumn";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "categoriaTarifa" && $this->metodo == "agregarTipos") {
                    $this->metodo = "añadirTipos";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "pedido" && $this->metodo == "agregarLogotipos") {
                    $this->metodo = "añadirLogotipos";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "pedido" && $this->metodo == "agregarUsuario") {
                    $this->metodo = "añadirUsuario";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "patron" && $this->metodo == "agregarTarifas") {
                    $this->metodo = "añadirTarifas";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "patron" && $this->metodo == "agregarArticulos") {
                    $this->metodo = "añadirArticulos";
                    $isCorrectMetod = true;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                if ($this->metodo == "actualizar" && $this->controlador != "articulo") {
                    
                    $this->metodo = "update";
                    $isCorrectMetod = true;
                }

                if ($this->controlador == "categoriaTarifa" && $this->metodo == "desactivarTipo") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "categoriaTarifa" && $this->metodo == "activarTipo") {
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "pedido" && $this->metodo == "validar") {
                    $this->metodo = "validarPedido";
                    $isCorrectMetod = true;
                }
            }

            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                if ($this->metodo == "eliminar" && $this->controlador != "articulo") {
                    $this->metodo = "delete";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "patron" && $this->metodo == "removerTarifas") {
                    $this->metodo = "quitarTarifas";
                    $isCorrectMetod = true;
                }
                if ($this->controlador == "patron" && $this->metodo == "removerArticulos") {
                    $this->metodo = "quitarArticulos";
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
