<?php
session_start();

// Si la sesión no esta activa lo mandamos al login
$url = $_SERVER['REQUEST_URI'] . 'frontend';
if (!$_SESSION['activo']) {
  header('Location: ../login?url=' . urlencode($url));
} else {
  if (isset($_SESSION['usuario'])) {
    require_once 'backend/api/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable('backend/api/');
    $dotenv->load();

    $HOST = $_ENV['HOST'];
    $USER = $_ENV['DDBB_USER'];
    $PASSWORD = $_ENV['DDBB_PASSWORD'];
    $BD = $_ENV['BD'];
    $BD_ARTICULOS = $_ENV['BD_ARTICULOS'];
    $BD_USUARIOS = $_ENV['BD_USUARIOS'];

    $DIALECT = $_ENV['dialect'];
    require_once 'backend/api/api/models/connection.php';
    new Connection($DIALECT, $HOST, $BD, $BD_ARTICULOS, $BD_USUARIOS, $USER, $PASSWORD);


    require_once 'backend/api/api/models/usuarioModel.php';
    $usuario = new Usuario;

    $aplicacionID = 11;

    //COMPROBAMOS SI EL USUARIO LOGUEADO TIENE ACCESO A LA APLICACIÓN Y SU ROL EN CASO AFIRMATIVO
    $usuarioLogged = $_SESSION['usuario'];
    $permisoLogged = $usuario->getPermiso($usuarioLogged->id, $aplicacionID);
    if ($permisoLogged) {
      $_SESSION['rol'] = $permisoLogged->rol;
      header("location:http://192.168.0.90/serigrafia/frontend");
    }

    //SI  NO TIENE ACCESO A LA APP LO MANDAMOS AL INDEX
    if (!$permisoLogged) {
      $err = "Error, Este usuario no cuenta con permiso para acceder a la Gestión de Usuarios y Aplicaciones";
      echo "<script> alert('" . $err . "'); </script>";
      header('Location: ../../index.php');
    }
  }
}
