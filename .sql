create database perez


CREATE TABLE categorias (
categoria_id SERIAL PRIMARY KEY,
categoria_nombre VARCHAR(50) NOT NULL,
categoria_situacion SMALLINT DEFAULT 1
);

CREATE TABLE prioridades (
prioridad_id SERIAL PRIMARY KEY,
prioridad_nombre VARCHAR(50) NOT NULL,
prioridad_situacion SMALLINT DEFAULT 1
);


CREATE TABLE productos (
producto_id SERIAL PRIMARY KEY,
producto_nombre VARCHAR(100) NOT NULL,
producto_cantidad INTEGER NOT NULL,
categoria_id INTEGER NOT NULL,
prioridad_id INTEGER NOT NULL,
producto_comprado SMALLINT DEFAULT 0,
producto_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (categoria_id) REFERENCES categorias(categoria_id),
FOREIGN KEY (prioridad_id) REFERENCES prioridades(prioridad_id)
);


