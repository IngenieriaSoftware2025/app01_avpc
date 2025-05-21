create database perez

create table productos(
id_producto serial primary key,
nombre_producto varchar(100) not null,
cantidad_producto integer,
id_categoria integer,
id_prioridad integer,
estado char(1),
situacion_producto smallint default 1,
foreign key (id_categoria) references categorias(id_categoria),
foreign key (id_prioridad) references prioridades(id_prioridad)
)

create table categorias(
id_categoria serial primary key,
nombre_categoria varchar(100)
)

create table prioridades(
id_prioridad serial primary key,
nivel_prioridad char(1)
)
