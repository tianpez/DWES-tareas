

-- Tabla de CATEGORIA 
DROP TABLE IF EXISTS categoria;

CREATE TABLE categoria
	(
	cat_id INTEGER(11) NOT NULL AUTO_INCREMENT,
	cat_nombre VARCHAR(50) NOT NULL,
	PRIMARY KEY(cat_id)
	);

	



	-- Tabla de ARTICULOS con clave AUTO_INCREMENT

DROP TABLE IF EXISTS articulos;

CREATE TABLE articulos
	(
	art_id INTEGER(11) NOT NULL,
	art_nombre VARCHAR(50) NOT NULL,
	art_categoria INTEGER(11) NOT NULL,
	art_cantidad INTEGER(11) NOT NULL,
	art_preciounitario FLOAT NOT NULL,
	PRIMARY KEY(art_id),
	FOREIGN KEY(art_categoria) REFERENCES categoria(cat_id)
);




-- Tabla VENTA

DROP TABLE IF EXISTS venta;

CREATE TABLE venta
(
ven_id INTEGER(11) NOT NULL AUTO_INCREMENT,
ven_fecha DATE NOT NULL,
ven_importe FLOAT NOT NULL,
ven_pagada TINYINT(1) NOT NULL,
PRIMARY KEY(ven_id),
FOREIGN KEY(ven_id) REFERENCES linea_venta(lin_venta)
);


-- Tabla LINEA DE VENTA

DROP TABLE IF EXISTS linea_venta;

CREATE TABLE linea_venta
(
lin_id INTEGER(11) NOT NULL AUTO_INCREMENT,
lin_venta INTEGER(11) NOT NULL,
lin_articulo INTEGER(11) NOT NULL,
lin_cantidad INTEGER(11) NOT NULL,
PRIMARY KEY(lin_id),
FOREIGN KEY(lin_venta) REFERENCES venta(ven_id),
FOREIGN KEY(lin_articulo) REFERENCES articulos(art_id)
);





---
---
---
---

-- Tabla de CATEGORIA 


CREATE TABLE dwesRepaso1.categoria
	(
	cat_id INTEGER(11) not NULL AUTO_INCREMENT,
	cat_nombre VARCHAR(50) NOT NULL,
	PRIMARY KEY(cat_id)
	);

	


	-- Tabla de ARTICULOS con clave AUTO_INCREMENT

DROP TABLE IF EXISTS dwesRepaso1.articulos;

CREATE TABLE dwesRepaso1.articulos
	(
	art_id INTEGER(11) NOT NULL,
	art_nombre VARCHAR(50) NOT NULL,
	art_categoria INTEGER(11) NOT NULL,
	art_cantidad INTEGER(11) NOT NULL,
	art_preciounitario FLOAT NOT NULL,
	PRIMARY KEY(art_id),
	FOREIGN KEY(art_categoria) REFERENCES categoria(cat_id)
);




-- Tabla VENTA

DROP TABLE IF EXISTS venta;

CREATE TABLE dwesRepaso1.venta
(
ven_id INTEGER(11) NOT NULL AUTO_INCREMENT,
ven_fecha DATE NOT NULL,
ven_importe FLOAT NOT NULL,
ven_pagada TINYINT(1) NOT NULL,
PRIMARY KEY(ven_id)

);


-- Tabla LINEA DE VENTA

DROP TABLE IF EXISTS linea_venta;

CREATE TABLE dwesRepaso1.linea_venta
(
lin_id INTEGER(11) NOT NULL AUTO_INCREMENT,
lin_venta INTEGER(11) NOT NULL,
lin_articulo INTEGER(11) NOT NULL,
lin_cantidad INTEGER(11) NOT NULL,
PRIMARY KEY(lin_id)

);




alter table dwesRepaso1.venta
add constraint FOREIGN KEY(ven_id) REFERENCES linea_venta(lin_venta);



alter table dwesRepaso1.linea_venta
add constraint FOREIGN KEY(lin_venta) REFERENCES venta(ven_id);

alter table dwesRepaso1.linea_venta
add constraint FOREIGN KEY(lin_articulo) REFERENCES articulos(art_id);