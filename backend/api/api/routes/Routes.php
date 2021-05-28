<?php

class Router{
    public static function run(Request $request){
        $controlador = $request->getControlador() . "Controller";
        $ruta = ROOT . "controllers" . DS . $controlador . ".php";
        $metodo = $request->getMetodo();
        $argumento = $request->getArgumento();
        
        if(is_readable($ruta)){
            require_once $ruta ;
            
            $controlador = new $controlador;
            if(!isset($argumento)){
                call_user_func(array($controlador,$metodo));
            }else{
                call_user_func(array($controlador,$metodo),$argumento);
            }
        }
    }
}