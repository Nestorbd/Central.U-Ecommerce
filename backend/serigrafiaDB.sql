DROP Database if EXISTS serigrafiabd;
create database serigrafiabd;

use serigrafiabd;

drop table if EXISTS cliente_individual;
create table cliente_individual (
id int primary key auto_increment,
nombre varchar(40) not null,
apellidos varchar(40) not null,
telefono varchar(20),
email varchar(100),
NIF varchar(20)
);

drop table if EXISTS cliente_empresa;
create table cliente_empresa (
    id int primary key auto_increment,
    nombre varchar(40),
    telefono varchar(20),
    CIF varchar(20)
);

drop table if EXISTS cliente_direccion;
create table cliente_direccion (
    id int primary key auto_increment,
    calle varchar(150) not null,
    numero varchar(10) not null,
    municipio varchar(40) not null,
    provincia varchar(40) not null,
    codigo_postal varchar(10) not null,
    id_individual int,
    id_empresa int,


    foreign key (id_individual) REFERENCES cliente_individual (id),
    foreign key (id_empresa) REFERENCES cliente_empresa (id)
);

drop table if EXISTS logotipos;
create table logotipos (
    id int primary key auto_increment,
    nombre varchar(40) not null,
    imagen blob not null,
    id_individual int,
    id_empresa int,

    foreign key (id_individual) REFERENCES cliente_individual (id),
    foreign key (id_empresa) REFERENCES cliente_empresa (id)
);

drop table if EXISTS usuario_rol;
create table usuario_rol (
    id int primary key auto_increment,
    nombre varchar(40),
    activo boolean default true
);

drop table if EXISTS usuario;
create table usuario (
    id int primary key auto_increment,
    nombre varchar(40) not null,
    activo boolean default true,
    id_rol int not null,

    foreign key (id_rol) REFERENCES usuario_rol(id)
);

drop table if EXISTS estado_pedido;
create table estado_pedido (
    id int primary key auto_increment,
    nombre varchar(40)
);

drop table if EXISTS pedidos;
create table pedidos (
    id int primary key auto_increment,
    esta_firmado BOOLEAN,
    parte_trabajo varchar(20),
    fecha_terminacion_trabajo date,
    observaciones varchar(500),
    validado boolean,
    timestamp timestamp,
    id_usuario int,
    id_estado int,
    id_individual int,
    id_empresa int,


    foreign key (id_individual) REFERENCES cliente_individual (id),
    foreign key (id_empresa) REFERENCES cliente_empresa (id),
    foreign key (id_usuario) REFERENCES usuario (id),
    foreign key (id_estado) REFERENCES estado_pedido (id)
);

drop table if EXISTS logotipos_pedido;
create table logotipos_pedido (
    id_logotipos int not null,
    id_pedidos int not null,

    primary key (id_logotipos, id_pedidos),
    foreign key (id_pedidos) REFERENCES pedidos(id),
    foreign key (id_logotipos) REFERENCES logotipos(id)
);

drop table if EXISTS bocetos;
create table bocetos (
    id int primary key auto_increment,
    imagen blob not null,
    id_pedidos int,

    foreign key (id_pedidos) REFERENCES pedidos(id)
);

drop table if EXISTS articulos;
create table articulos (
    id int primary key auto_increment,
    nombre varchar(40) not null,
    codigo_barra varchar(20) not null,
    stock int not null,
    activo boolean default true
);

drop table if EXISTS articulos_pedidos;
create table articulos_pedidos (
    id_articulo int not null,
    id_pedidos int not null,

    primary key (id_articulo, id_pedidos),
    foreign key (id_articulo) REFERENCES articulos(id),
    foreign key (id_pedidos) REFERENCES pedidos(id)
);

drop table if EXISTS articulo_talla;
create table articulo_talla (
    id int primary key auto_increment,
    nombre varchar(40),
    activo boolean default true,
    id_articulo int,

    foreign key (id_articulo) REFERENCES articulos(id)
);

drop table if EXISTS articulo_categoria;
create table articulo_categoria (
    id int primary key auto_increment,
    nombre varchar(40),
    activo boolean default true,
    id_articulo int,

    foreign key (id_articulo) REFERENCES articulos(id)
);

drop table if EXISTS articulo_color;
create table articulo_color (
    id int primary key auto_increment,
    nombre varchar(40),
    activo boolean default true,
    id_articulo int,

    foreign key (id_articulo) REFERENCES articulos (id)
);

drop table if EXISTS tarifas_categorias;
create table tarifas_categorias (
    id int primary key auto_increment,
    nombre varchar(40),
    activo boolean default true
);

drop table if EXISTS tarifas_tipo;
create table tarifas_tipo (
    id int primary key auto_increment,
    nombre varchar(40),
    activo boolean default true
);

drop table if EXISTS categorias_tipo;
create table categorias_tipo (
    id_categoria int not null,
    id_tipo int not null,

    primary key (id_categoria, id_tipo),
    foreign key (id_categoria) REFERENCES tarifas_categorias(id),
    foreign key (id_tipo) REFERENCES tarifas_tipo(id)
);

drop table if EXISTS tarifas;
create table tarifas (
    id int primary key auto_increment,
    nombre varchar(40) not null,
    precio float not null,
    timestamp timestamp,
    activo boolean default true,
    id_categoria int not null,
    id_tipo int not null,

    foreign key (id_categoria) REFERENCES tarifas_categorias(id),
    foreign key (id_tipo) REFERENCES tarifas_tipo(id)
);

drop table if EXISTS pedidos_tarifas;
create table pedidos_tarifas (
    id_tarifa int not null,
    id_pedido int not null,

    primary key (id_tarifa,id_pedido),
    foreign key (id_tarifa) REFERENCES tarifas(id),
    foreign key (id_pedido) REFERENCES pedidos(id)
);

drop table if EXISTS update_precio;
create table update_precio (
    id int primary key auto_increment,
    precio_anterior float not null,
    timestamp timestamp,
    id_tarifa int not null,

    foreign key (id_tarifa) REFERENCES tarifas(id)
);


DELIMITER |
create trigger tarifas_AU_Trigger
    AFTER UPDATE
    ON tarifas
    FOR EACH ROW
BEGIN
    INSERT into update_precio (precio_anterior, id_tarifa)
        values (id, old.precio);
end |
DELIMITER ;
