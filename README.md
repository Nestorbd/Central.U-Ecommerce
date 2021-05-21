# Central.U-Ecommerce

Este proyecto esta dirigido a la empresa Central Uniformes SL.

La aplicación es para el uso interino de la empresa, que consiste en una pagina web en la que se podrá generar un pedido para un cliente y en este pedido se podrá insertar los logotipos del cliente y ubicarlos en un patrón de un articulo. Luego, este pedido tiene que ser validado por el departamento que se encarga del trabajo y también debe asignar una fecha de terminación de trabajo. Finalmente, el cliente tiene que firmar el documento para que su pedido se lleve a cabo.

# Indice
- [Central.U-Ecommerce](#centralu-ecommerce)
- [Manual de instalación](#manual-de-instalación)
  - [Backend](#backend)
    - [Instalar XAMPP](#instalar-xampp)
    - [Configurar XAMPP](#configurar-xampp)
    - [Instalar Backend](#instalar-backend)
  - [Frontend](#frontend)
- [Arquitectura](#arquitectura)
  - [Backend](#backend-1)
    - [Rutas](#rutas)
    - [Controlador](#controlador)
    - [Modelos](#modelos)
  - [Frontend](#frontend-1)

# Manual de instalación

## Backend 

Para el funcionamiento de la aplicación primero tenemos que instalar el backend en el servidor.

### Instalar XAMPP
Primero, tenemos que instalar el [XAMPP](https://www.apachefriends.org/es/index.html).

Si abrimos el enlace nos abrirá esta pagína:

![xampp descargar](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_index.png)

Seleccionamos descargar y nos aparecerá la siguiente página:

![seleccionar version](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp-version.png)

En este proyecto lo hemos trabajado con la version 8.0.3 en Windows, pero se puede ejecutar en cualquiera de estas versiones, solo hay que habilitar las opciones adecuadas para su uso.

Le damos click a descargar la version que queramos usar de XAMPP y se nos descargara un instalador:

![descargar version](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp-version-descargar.png)


Cuando termine de descargar ejecutamos el instalador y nos tendrá que aparecer una ventana como esta:

![ventana XAMPP warning](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_warning.png)

Le damos a OK y nos llevara a la siguiente ventana en donde configuraremos la instalación del XAMPP:

![ventana XAMPP instalación welcome](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_wellcome.png)

Le damos a siguiente y nos aparecerá una pantalla en donde podemos elegir lo que se va a instalar,
seleccionamos los siguientes:

![ventana XAMPP selección](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_seleccion.png)

Le damos a siguiente y ahora podremos elegir en que carpeta queremos que se instale, en mi caso la dejare en la por defecto:

![ventana XAMP elegir lugar de instalación](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_instalacion.png)

Después de elegir el lugar de instalación le damos a siguiente y nos pedirá que elijamos un idioma para el panel de control, en mi caso voy a elegir ingles: 

![ventana XAMPP elegir idioma](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_idioma.png)

A continuación nos dirá que si queremos aprender más sobre Bitnami para XAMPP, en mi caso lo desmarco: 

![Bitnami For XAMPP](Documentacion/install_XAMP/XAMPP%20INSTALL/Bitnami%20For%20XAMPP.png)

Después de esto nos dirá que si estamos preparados para la instalación, cuando estés preparado le damos a siguiente y comenzara a instalarse el XAMPP: 

![XAMPP ready to install](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp_ready.png)

![XAMPP installing](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp-installing.png)

En medio de la instalación nos saldrá una ventana emergente del firewall para darle permiso a el servidor de apache, se lo damos:

![Apache allow access](Documentacion/install_XAMP/XAMPP%20INSTALL/apache_allow_access.png)

Una vez finalizada la instalación nos saldrá una ventana donde podemos elegir si queremos abrir el panel de control del XAMPP, lo seleccionamos y le damos a finalizar:

![XAMPP open control panel](Documentacion/install_XAMP/XAMPP%20INSTALL/xampp%20finish.png)

### Configurar XAMPP

Vamos a configurar el servidor de apache para poder usarlo con nuestra aplicación. 
Para hacerlo, primero, vamos a abrir el panel de control de XAMPP, una vez abierto le damos al botón de config que esta en la fila de Apache:

![XAMPP configurar apache](Documentacion/install_XAMP/XAMPP%20CONFIG/apache%20config.png)

Nos aparecerá varios archivos, primero vamos a ir al archivo de PHP (php.ini):

![php.ini](Documentacion/install_XAMP/XAMPP%20CONFIG/php.ini.png)

Abrimos el documento y buscamos (ctrl+b) "gd", le damos a buscar y nos aparecerá que la extension esta comentada, la descomentamos:

![buscar gd](Documentacion/install_XAMP/XAMPP%20CONFIG/buscar%20gd.png)

![descomentar gd](Documentacion/install_XAMP/XAMPP%20CONFIG/descomentasr%20gd.png)

Ahora guardamos el documento (ctrl+g).

Si aun asi da problemas dejare mis configuraciones al final para que podáis compararlas con las vuestras.

Cerramos el documento y ahora abrimos el httpd.conf:

![httpd.conf](Documentacion/install_XAMP/XAMPP%20CONFIG/httpd.conf.png)

Aquí solo tenemos que verificar si en el directorio donde esta alojado el XAMPP esta activo el AllowOverride, si esta en none lo cambiamos por All.

Y esto seria todo, si hay algún fallo más intentar mirar si el modulo rewrite esta activo.

Una vez terminado las configuraciones ya le podemos dar a start al servidor apache y al gestor de bases de datos MySQL.

**Mis configuraciones**

* [php.ini](Documentacion/install_XAMP/php.ini)
* [httpd.conf](Documentacion/install_XAMP/httpd.conf)

### Instalar Backend

Ahora que ya tenemos los servicios necesarios procedemos a instalar el backend.

Primero nos descargamos el archivo .zip de este repositorio o lo clonamos con git clone en el directorio que queramos. Una vez hecho esto, copiamos la carpeta backend y nos dirigimos a la carpeta htdocs que se encuentra en el directorio de instalación del XAMPP, ahí creamos una carpeta nueva para el proyecto y pegamos el backend.

Después, en el interior de la carpeta backend nos encontraremos con un archivo [.sql](backend/serigrafiaDB.sql), ejecutamos este archivo en el phpMyAdmin que descargamos junto con el XAMPP.

Para abrir el phpMyAdmin hay que ir al navegador y poner la siguiente ruta: 

http://localhost/phpmyadmin

Usuario: root

Contraseña:

Una vez dentro vamos a la pestaña donde pone importar, elegimos el archivo .sql antes mencionado y le damos a continuar.

Finalmente, para que el backend funcione hay que crear un archivo ".env" que sera donde definiremos la conexión a la base de datos, abrimos el archivo con un editor de texto y ponemos lo siguiente:



```
direccion del hosting, por ejemplo localhost.
HOST= "localhost"

DDBB_USER="root"
DDBB_PASSWORD=""

nombre de la base de datos, en este caso es serigrafiabd
BD="serigrafiabd"

dialect="mysql"

```

Si no ha ocurrido ningún error el backend esta instalado correctamente y listo para su uso.


## Frontend


# Arquitectura

## Backend

El backend esta hecho con el lenguaje PHP vainilla con una arquitectura simple MVC (Modelo Vista Controlador).

Lo primero que nos encontramos en el backend es el archivo [app.php](backend/api/api/app.php).

```
<?php 
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__))  .   DS);

$ruta = str_replace("/api","",  $_SERVER['REQUEST_URI']);
$_GET['url'] = $ruta;

require_once '../config/headers.php';
require_once "models/connection.php";
require_once "routes/request.php";
require_once "routes/Routes.php" ;

new Connection;

Router::run(new Request);
```

Este archivo es el primero que se ejecuta cuando hacemos una petición al backend.

Las primeras dos lineas son para poder saber en que ruta local esta el archivo y asi poder llamar a los demás sin ningún problema.

La tercera y cuarta linea nos da la ruta relativa por la que estamos accediendo al servidor y le quitamos las partes innecesarias para que el enrutado sea mas fácil.

Las lineas que faltan son para llamar a los headers que son los que definen como se van a pasar los datos al frontend y controla la política de CORS, para establecer la conexión a la base de datos y el enrutado que se va ha encargar de llamar al controlador y al método adecuado.

### Rutas

Dentro de la carpeta [routes](backend/api/api/routes) nos encontramos con los archivos [request.php](backend/api/api/routes/request.php) y [routes.php](backend/api/api/routes/routes.php).

En el primero nos encontraremos que esta dividido por los métodos GET, POST, PUT y DELETE, esto es para controlar mejor las rutas y no confundirse a la hora de mandar o recibir datos.

Si seguimos la arquitectura de métodos del controlador las rutas básicas para un CRUD se hacen automáticamente, si quieres añadir un método nuevo puedes fijarte en los que ya están puestos y adaptarlo al tuyo. La manera en la que esta definido es la siguiente:

controlador = "nombreTabla" + "Controller;
método = "nombremétodo";
Argumento = ID;

Imaginate que quieres ejecutar el método insert del controlador de pedido, pues lo que tenemos que poner en la ruta para ejecutar este método es el siguiente:

http://localhost/api/pedido/insertar

Cuando le envíes esto al backend con el método POST el ira primero a request.php y leerá:

pedido = pedidoController.php
insertar = insert

Esto se lo mandara a el archivo routes y el ejecutara el fichero pedidoController.php el método insert y dentro de ahí recogerá los datos que le enviemos.

### Controlador

La carpeta donde están los controladores es en [controllers](backend/api/api/controllers).

El controlador es el que se va a conectar con el modelo correspondiente para enviar y recibir información de la base de datos y enviar el resultado a el cliente que hace la llamada, normalmente este seria el frontend.

Los métodos principales para que un controlador funcione son:

* __construct()

  Es el que se encarga de iniciar el modelo para poder llamar a sus métodos. 

* getAll()

  Este método se encarga de llamar a la función encargada de pedir todos los datos que hay en una tabla.

* getOne($id)
  
  Al igual que getAll llama a otra función del modelo para recibir datos, pero en este caso le enviamos el id del dato que queramos ver.

  Para ello en la ruta debemos especificar que id es el que queremos, como por ejemplo:

  http://localhost/api/pedido/ver/15

  En esta ruta estamos diciendo que queremos que nos devuelva los datos del pedido con id = 15.

* insert()
  
  Este método recibe los parámetros almacenados en el input y los envía a una función que se encarga de insertar un nuevo campo con los datos enviados.

  Ha este método no es necesario especificarle ninguna id al igual que con getAll().

* update($id)

  Este método es parecido al insert, solo que en este también hace falta especificarle el id del campo que se quiera actualizar y pasar los datos por el input.

  Ej: http://localhost/api/pedido/actualizar/15

  Con esta ruta le estamos indicando que queremos actualizar el pedido con id = 15.

* delete($id)

  Al igual que los anteriores métodos hay que especificarle una id para saber que campo hay que eliminar, como por ejemplo:

  http://localhost/api/pedido/eliminar/15

  En esta ruta le estamos diciendo que elimine el pedido con id = 15.

Aparte de estas funciones básicas nos vamos 
a encontrar con otras mas especificas de cada controlador, pero básicamente hacen las mismas funciones que las anteriores con diferencias de tabla o algún dato muy especifico, como las de añadir que modifican tablas intermedias entre otras tablas o las de activar y desactivar campos que es para facilitar el uso de la aplicación.

También nos vamos a encontrar con una función en algunos controladores llamada uploadImage($imgName). En esta función lo que se hace es guardar la imagen recibida en el parámetro $_FILES en una ruta física del backend, para modificar esta ruta solo tendremos que ajustar la variable $imgFolder de la función.



### Modelos

La carpeta donde se ubican los modelos es [models](backend/api/api/models).

Un modelo se encarga de enviar y recibir datos del controlador y comunicarse con la base de datos.

Para comunicarse con la base de datos se usa el archivo [connection.php](backend/api/api/models/connection.php) que se inicia en el archivo app.php explicado anteriormente y cada modelo se conecta a esta conexión ya iniciada.

En cada modelo vamos a encontrar los siguientes métodos básicos:

* __construct()
  
  En este caso este método almacena la conexión en una variable para poder enviar y recibir información de la base de datos.

  Los métodos explicados a continuación tomaremos como referencia el modelo de pedido, asi que para otro método solo habrá que sustituir la palabra pedido por la del modelo correspondiente.

* getPedidos()

  En este método llamamos a todos los datos de una tabla y se lo devolvemos a el controlador. 

  También, nos encontraremos a menudo que por cada campo de la tabla se llaman a otros métodos que se encargan de buscar otros datos relacionados con dicho campo.

* getPedidoById($id)

  Este método es muy parecido al anterior con la diferencia que ha este hace falta pasar la id del campo a consultar.

* createPedido($data)

  A este método se le pasan los datos necesarios para crear un nuevo pedido y una vez creado devuelve la id de este pedido nuevo al controlador que se encargara de llamar a otro método para mostrarlo.

  También nos encontraremos con una variante de este método que seria createPedido($data,$img) en el que aparte de los datos le pasamos la ruta de la imagen en donde esta guardada, es importante saber que la ruta almacenada en la bse de datos no es la ruta física sino la relativa como la que usamos para conectar con el backend. Para ello, dentro del método de este método se define esa ruta relativa:

  ```
    $img = str_replace("C:" . DS . "xampp" . DS . "htdocs" . DS, "http://localhost/", $img);

    $img = str_replace(DS, '/', $img);
  ```
  En la primera linea remplazamos la parte de la ruta que no interesa y la reemplazamos por la ruta web. En la segunda cambiamos la barra invertida "\\" por esta otra "/".

* updatePedido($id, $dataNew)

    En este método actualizaremos los datos de un campo cuya id sea igual a la que le pasemos por parámetro.

    Una vez insertados los datos que están almacenados en la variable $dataNew como JSON se le pasara un true o false al controlador dependiendo de si se ha podido actualizar o no los datos del campo.

* deletePedido($id)

  A este método se le pasa también una id com parámetro y se encarga de eliminar el campo con esa id. Como el updatePedido este le devolverá un true o false dependiendo de si se ha podido eliminar el campo.

También nos podemos encontrar otros métodos distintos a los anteriores pero su funcionamiento es bastante similar, la diferencia son las tablas a las que se conectan y los datos que necesitan.
 
## Frontend







