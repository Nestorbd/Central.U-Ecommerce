DROP Database if EXISTS serigrafiabd;
create database serigrafiabd;

use serigrafiabd;

drop table if EXISTS cliente_individual;
create table cliente_individual (
id_individual int primary key auto_increment,
nombre varchar(40) not null,
apellidos varchar(40) not null,
telefono varchar(20),
email varchar(100),
NIF varchar(20)
);

drop table if EXISTS cliente_empresa;
create table cliente_empresa (
    id_empresa int primary key auto_increment,
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


    foreign key (id_individual) REFERENCES cliente_individual (id_individual)
    on update cascade
    on delete cascade,
    foreign key (id_empresa) REFERENCES cliente_empresa (id_empresa)
    on update cascade
    on delete cascade
);

drop table if EXISTS logotipos;
create table logotipos (
    id int primary key auto_increment,
    nombre varchar(40) not null,
    imagen_png blob null,
    imagen_svg blob null,
    id_individual int,
    id_empresa int,

    foreign key (id_individual) REFERENCES cliente_individual (id_individual)
    on update cascade
    on delete cascade,
    foreign key (id_empresa) REFERENCES cliente_empresa (id_empresa)
    on update cascade
    on delete cascade
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
    validado boolean,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    id_estado int,
    id_individual int,
    id_empresa int,

    foreign key (id_individual) REFERENCES cliente_individual (id_individual)
    on update cascade
    on delete cascade,
    foreign key (id_empresa) REFERENCES cliente_empresa (id_empresa)
    on update cascade
    on delete cascade,
    foreign key (id_estado) REFERENCES estado_pedido (id)
    on update cascade
    on delete cascade
);

drop table if EXISTS usuario_act_pedido;
create table usuario_act_pedido (
    id_usuario int,
    id_pedido int,
    id_estado int,

    primary key (id_usuario, id_pedido, id_estado),
    foreign key (id_pedido) REFERENCES pedidos(id)
    on update cascade
    on delete cascade,
    foreign key (id_estado) REFERENCES estado_pedido(id)
    on update cascade
    on delete cascade
);

drop table if EXISTS logotipos_pedido;
create table logotipos_pedido (
    id_logotipos int not null,
    id_pedidos int not null,

    primary key (id_logotipos, id_pedidos),
    foreign key (id_pedidos) REFERENCES pedidos(id)
    on update cascade
    on delete cascade,
    foreign key (id_logotipos) REFERENCES logotipos(id)
    on update cascade
    on delete cascade
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
    activo boolean default true,

    primary key (id_categoria, id_tipo),
    foreign key (id_categoria) REFERENCES tarifas_categorias(id)
    on update cascade
    on delete cascade,
    foreign key (id_tipo) REFERENCES tarifas_tipo(id)
    on update cascade
    on delete cascade
);

drop table if EXISTS tarifas;
create table tarifas (
    id int primary key auto_increment,
    nombre varchar(40) not null,
    precio float not null,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    fecha_actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    activo boolean default true,
    id_categoria int not null,
    id_tipo int not null,

    foreign key (id_categoria) REFERENCES tarifas_categorias(id)
    on update cascade
    on delete cascade,
    foreign key (id_tipo) REFERENCES tarifas_tipo(id)
    on update cascade
    on delete cascade
);

drop table if EXISTS update_precio;
create table update_precio (
    id int primary key auto_increment,
    precio_anterior float not null,
    precio_actualizacion_tarifa TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_tarifa int not null,

    foreign key (id_tarifa) REFERENCES tarifas(id)
    on update cascade
    on delete cascade
);

drop table if EXISTS patron;
create table patron (
    id int primary key auto_increment,
    imagen blob,
    observaciones varchar(400),
    id_pedido int,

    foreign key (id_pedido) REFERENCES pedidos(id)
    On update cascade
    On delete cascade
);

drop database if EXISTS patron_articulo;
create table patron_articulo (
    id_patron int not null,
    id_articulo int not null,
    cantidad int,

    primary key (id_patron, id_articulo),
    foreign key (id_patron) references patron(id)
    On update cascade
    On delete cascade
);

drop table if EXISTS patron_tarifa;
create table patron_tarifa (
    id_patron int not null,
    id_tarifa int not null,

    primary key (id_patron, id_tarifa),
    foreign key (id_patron) references patron(id)
    On update cascade
    On delete cascade,
    foreign key (id_tarifa) references tarifas(id)
    On update cascade
    On delete cascade
);

drop table if EXISTS por_defecto;
create table por_defecto (
    id int primary key auto_increment,
    nombre varchar(40),
    imagen blob not null,
    activo boolean
);

DELIMITER |
create trigger tarifas_AU_Trigger
    AFTER UPDATE
    ON tarifas
    FOR EACH ROW
BEGIN
IF new.precio != old.precio THEN
    INSERT into update_precio (id_tarifa, precio_anterior)
        values (old.id, old.precio);
END IF;
end |
DELIMITER ;

DELIMITER |
create trigger categoriaTarifa_AU_Trigger
    AFTER UPDATE
    ON tarifas_categorias
    FOR EACH ROW
BEGIN
    Update categorias_tipo set activo = new.activo where id_categoria = old.id;
end |
DELIMITER ;

DELIMITER |
create trigger tipoTarifa_AU_Trigger
    AFTER UPDATE
    ON tarifas_tipo
    FOR EACH ROW
BEGIN
    Update categorias_tipo set activo = new.activo where id_tipo = old.id;
end |
DELIMITER ;


insert into cliente_individual  VALUES (null,"nestor","batista","626202874","nestor@CU.es","54682321");
insert into cliente_empresa  VALUES (null,"Central Uniformes", "626202874","777777");
insert into cliente_individual  VALUES (null,"Gonzalo","Santana","626202874","gonzalo@CU.es","878454856");
insert into cliente_empresa  VALUES (null,"KFC","626202874", "666666");

insert into cliente_direccion values (null,"C/ El Router", "135B", "Las Palmas", "Las Palmas", "35001", null,1);
insert into cliente_direccion values (null,"C/ Obispo Pildain", "155", "Arucas", "Las Palmas", "35400", 1,null);
