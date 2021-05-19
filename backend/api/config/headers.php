<?php
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Content-Type: application/json');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization, X-Requested-With');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
       
        }

        if(isset($_SERVER['HTTP_POSTMAN_TOKEN'])){
            header('Content-Type: application/json');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization, X-Requested-With');
        }
        
        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         
            
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
            exit(0);
        }
