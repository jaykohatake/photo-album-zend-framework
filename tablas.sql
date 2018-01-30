CREATE DATABASE albumes;

USE albumes;

CREATE TABLE Persona(
documento INTEGER(10) PRIMARY KEY,
nombre VARCHAR(50) NOT NULL
);

CREATE TABLE Usuario(
documento INTEGER(10) PRIMARY KEY REFERENCES Persona(documento),
nickName VARCHAR(30) NOT NULL UNIQUE,
avatar VARCHAR(50)
);

CREATE TABLE Album(
idAlbum INTEGER (8) AUTO_INCREMENT PRIMARY KEY,
nickName VARCHAR(30) REFERENCES Usuario(nickName),
nombre VARCHAR(30) NOT NULL,
descripcion VARCHAR(100)
);

CREATE TABLE Imagen(
idImagen INTEGER(8) AUTO_INCREMENT PRIMARY KEY,
foto VARCHAR(50) NOT NULL,
descripcion VARCHAR(100),
titulo VARCHAR(50) NOT NULL,
comentario VARCHAR(100)
);

CREATE TABLE ImagenxAlbum(
idImagen INTEGER(8),
idAlbum INTEGER(8),
numeroOrden INTEGER(2) NOT NULL,
PRIMARY KEY(idImagen, idAlbum)
);

--INSERTS
INSERT INTO Persona(documento, nombre) VALUES(666,'Aquiles Doyver Galindo Reina');

INSERT INTO Usuario(documento, nickName, avatar) VALUES(666, 'ElverGalarga', NULL);

INSERT INTO Album(nickName, nombre, descripcion) VALUES('ElverGalarga','Album Calidoso', 'El album mas calidoso del mundo entero!!');