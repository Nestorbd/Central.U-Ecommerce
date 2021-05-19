# Central.U-Ecommerce

Este proyecto esta dirigido a la empresa Central Uniformes SL.

La aplicación es para el uso interino de la empresa, que consiste en una pagina web en la que se podrá generar un pedido para un cliente y en este pedido se podrá insertar los logotipos del cliente y ubicarlos en un patrón de un articulo. Luego, este pedido tiene que ser validado por el departamento que se encarga del trabajo y también debe asignar una fecha de terminación de trabajo. Finalmente, el cliente tiene que firmar el documento para que su pedido se lleve a cabo.

# Manual de instalación

## Backend 

Para el funcionamiento de la aplicación primero tenemos que instalar el backend en el servidor.

### Instalar XAMPP
Primero, tenemos que instalar el [XAMPP](https://www.apachefriends.org/es/index.html).

Si abrimos el enlace nos abrirá esta pagína:

![xampp index.html]()

Seleccionamos descargar:

![xampp descargar]()

Ahora, en la siguiente ventana, seleccionamos que version queremos instalar:

![seleccionar version]()

En este proyecto lo hemos trabajado con la version 8.0.3 en Windows, pero se puede ejecutar en cualquiera de estas versiones, solo hay que habilitar las opciones adecuadas para su uso.

Le damos click a descargar la version que queramos usar de XAMPP y se nos descargara un instalador:

![descargar version]()

![descargando]()

Cuando termine de descargar ejecutamos el instalador y nos tendrá que aparecer una ventana como esta:

![ventana XAMPP warning]()

Le damos a OK y nos llevara a la siguiente ventana en donde configuraremos la instalación del XAMPP:

![ventana XAMPP instalación welcome]()

Le damos a siguiente y nos aparecerá una pantalla en donde podemos elegir lo que se va a instalar,
seleccionamos los siguientes:

![ventana XAMPP selección]()

Le damos a siguiente y ahora podremos elegir en que carpeta queremos que se instale, en mi caso la dejare en la por defecto:

![ventana XAMP elegir lugar de instalación]()

Después de elegir el lugar de instalación le damos a siguiente y nos pedirá que elijamos un idioma para el panel de control, en mi caso voy a elegir ingles: 

![ventana XAMPP elegir idioma]()

A continuación nos dirá que si queremos aprender más sobre Bitnami para XAMPP, en mi caso lo desmarco: 

![Bitnami For XAMPP]()

Después de esto nos dirá que si estamos preparados para la instalación, cuando estés preparado le damos a siguiente y comenzara a instalarse el XAMPP: 

![XAMPP ready to install]()

![XAMPP installing]()

En medio de la instalación nos saldrá una ventana emergente del firewall para darle permiso a el servidor de apache, se lo damos:

![Apache allow access]()

Una vez finalizada la instalación nos saldrá una ventana donde podemos elegir si queremos abrir el panel de control del XAMPP, lo seleccionamos y le damos a finalizar:

![XAMPP open control panel]()

### Configurar XAMPP

Vamos a configurar el servidor de apache para poder usarlo con nuestra aplicación. 
Para hacerlo, primero, vamos a abrir el panel de control de XAMPP, una vez abierto le damos al botón de config que esta en la fila de Apache:

![XAMPP configurar apache]()

Nos aparecerá varios archivos, primero vamos a ir al archivo de PHP (php.ini):

![php.ini]()

Abrimos el documento y buscamos (ctrl+b) "gd", le damos a buscar y nos aparecerá que la extension esta comentada, la descomentamos:

![buscar gd]()

![descomentar gd]()

Ahora guardamos el documento (ctrl+g).

Si aun asi da problemas dejare mis configuraciones al final para que podáis compararlas con las vuestras.

Cerramos el documento y ahora abrimos el httpd.conf:

![httpd.conf]()

Aquí solo tenemos que verificar si en el directorio donde esta alojado el XAMPP esta activo el AllowOverride, si esta en none lo cambiamos por All:

![AllowOverride All]()

Y esto seria todo, si hay algún fallo más intentar mirar si el modulo rewrite esta activo.

Una vez terminado las configuraciones ya le podemos dar a start al servidor apache y al gestor de bases de datos MySQL.

**Mis configuraciones**

* [php.ini]()
* [httpd.conf]()









