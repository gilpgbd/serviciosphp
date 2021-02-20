CREATE DATABASE servicios
  CHARACTER SET = utf8
  COLLATE = utf8_spanish_ci;
CREATE USER 'ususerv'@'localhost'
  IDENTIFIED BY 'usupass';
GRANT ALL PRIVILEGES
  ON servicios.*
  TO 'ususerv'@'localhost';
FLUSH PRIVILEGES;
USE servicios;
CREATE TABLE Pasatiempo (
  id INTEGER PRIMARY KEY
    AUTO_INCREMENT,
  nombre VARCHAR(255) NOT NULL
)
CHARSET = utf8
COLLATE = utf8_spanish_ci
ENGINE = InnoDB;
CREATE TABLE Rol (
  id VARCHAR(255) PRIMARY KEY,
  descripcion VARCHAR(255)
    NOT NULL
)
CHARSET = utf8
COLLATE = utf8_spanish_ci
ENGINE = InnoDB;
CREATE TABLE Imagen (
  id INTEGER PRIMARY KEY
    AUTO_INCREMENT,
  bytes LONGBLOB NOT NULL
)
CHARSET = utf8
COLLATE = utf8_spanish_ci
ENGINE = InnoDB;
CREATE TABLE Usuario (
  cue VARCHAR(255),
  imagenId INTEGER,
  mtch VARCHAR(255) NOT NULL,
  nombre VARCHAR(255) NOT NULL,
  pasatiempoId INTEGER,
  CONSTRAINT USU_PK
    PRIMARY KEY (cue),
  CONSTRAINT USU_IMG_FK
    FOREIGN KEY (imagenId)
    REFERENCES Imagen (id),
  CONSTRAINT USU_PAS_FK
    FOREIGN KEY (pasatiempoId)
    REFERENCES Pasatiempo (id)
)
CHARSET = utf8
COLLATE = utf8_spanish_ci
ENGINE = InnoDB;
CREATE TABLE UsuarioRol (
  usuarioCue VARCHAR(255)
    NOT NULL,
  rolId VARCHAR(255) NOT NULL,
  CONSTRAINT URL_PK
    PRIMARY KEY
    (usuarioCue, rolId),
  CONSTRAINT URL_USU_PK
    FOREIGN KEY (usuarioCue)
    REFERENCES Usuario (cue),
  CONSTRAINT URL_ROL_PK
    FOREIGN KEY (rolId)
    REFERENCES Rol (id)
)
CHARSET = utf8
COLLATE = utf8_spanish_ci
ENGINE = InnoDB;
INSERT INTO Rol (id, descripcion)
  VALUES
  ('Administrador',
    'Administra el sistema.'),
  ('Cliente', 'Usa el sistema.');
INSERT INTO Usuario
 (cue, mtch, nombre)
 VALUES
 ('admin', SHA2('istra',256), 'Cambia');
INSERT INTO UsuarioRol
 (usuarioCue, rolId)
 VALUES
 ('admin', 'Administrador');