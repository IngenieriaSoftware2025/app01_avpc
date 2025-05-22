create database perez

CREATE TABLE categorias (
    categoria_id SERIAL PRIMARY KEY,
    categoria_nombre VARCHAR(50) NOT NULL,
    categoria_codigo CHAR(1) NOT NULL, --hogar, limpieza, alimentos
    categoria_situacion SMALLINT DEFAULT 1
);

CREATE TABLE productos (
    producto_id SERIAL PRIMARY KEY,
    producto_nombre VARCHAR(100) NOT NULL,
    producto_cantidad INT NOT NULL,
    producto_categoria_id INT NOT NULL,
    producto_prioridad CHAR(1) NOT NULL, --alta, media, baja
    producto_comprado SMALLINT DEFAULT 0, --0 no 1 si
    producto_situacion SMALLINT DEFAULT 1,
    FOREIGN KEY (producto_categoria_id) REFERENCES categorias(categoria_id)
);

INSERT INTO categorias (categoria_nombre, categoria_codigo) VALUES 
('Alimentos', 'A');
INSERT INTO categorias (categoria_nombre, categoria_codigo) VALUES 
('Limpieza', 'L');
INSERT INTO categorias (categoria_nombre, categoria_codigo) VALUES 
('Hogar', 'H');

select * from productos
select * from categorias