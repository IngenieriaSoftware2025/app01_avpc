create database perez


CREATE TABLE categorias (
categoria_id SERIAL PRIMARY KEY,
categoria_nombre VARCHAR(50) NOT NULL,
categoria_situacion SMALLINT DEFAULT 1
);


CREATE TABLE prioridades (
prioridad_id SERIAL PRIMARY KEY,
prioridad_nombre VARCHAR(20) NOT NULL,
prioridad_orden INT NOT NULL,
prioridad_situacion SMALLINT DEFAULT 1
);


CREATE TABLE productos (
producto_id SERIAL PRIMARY KEY,
producto_nombre VARCHAR(100) NOT NULL,
producto_cantidad INT NOT NULL,
producto_categoria_id INT NOT NULL,
producto_prioridad_id INT NOT NULL,
producto_comprado SMALLINT DEFAULT 0,
producto_situacion SMALLINT DEFAULT 1,
FOREIGN KEY (producto_categoria_id) REFERENCES categorias(categoria_id),
FOREIGN KEY (producto_prioridad_id) REFERENCES prioridades(prioridad_id)
);


INSERT INTO categorias (categoria_nombre) VALUES 
('Alimentos');
INSERT INTO categorias (categoria_nombre) VALUES 
('Higiene');
INSERT INTO categorias (categoria_nombre) VALUES 
('Hogar');



INSERT INTO prioridades (prioridad_nombre, prioridad_orden) VALUES 
('Alta', 1);
INSERT INTO prioridades (prioridad_nombre, prioridad_orden) VALUES 
('Media', 2);
INSERT INTO prioridades (prioridad_nombre, prioridad_orden) VALUES 
('Baja', 3);


