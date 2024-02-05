-- Crear la base de datos y seleccionarla
CREATE DATABASE IF NOT EXISTS enquestas;
USE enquestas;

-- Crear la tabla Empresa
CREATE TABLE Empresa (
  id_empresa INT AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(255) NOT NULL
);

-- Crear la tabla Usuarios
CREATE TABLE Usuarios (
  id_usuarios INT AUTO_INCREMENT PRIMARY KEY,
  nombre varchar(255) NOT NULL,
  correo VARCHAR(255) NOT NULL,
  contrasenya VARCHAR(255) NOT NULL,
  CONSTRAINT correo_valido CHECK (correo REGEXP '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$')
);

-- Crear la tabla enquestadores
CREATE TABLE enquestadores (
  id_enquestadores INT AUTO_INCREMENT PRIMARY KEY,
  localizacion VARCHAR(255) NOT NULL,
  id_usuarios INT,
  id_empresa INT,
  FOREIGN KEY (id_usuarios) REFERENCES Usuarios(id_usuarios) ON DELETE CASCADE,
  FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa) ON DELETE CASCADE
);

-- Habilitar la extensión pgcrypto (no es necesario en MySQL)
-- Crear la función hash_password
DELIMITER //
CREATE FUNCTION hash_password(input_text VARCHAR(255)) RETURNS VARCHAR(64)
BEGIN
  DECLARE hashed_password VARCHAR(64);
  SET hashed_password = SHA2(CONCAT(input_text, 'mysalt'), 256); -- Puedes personalizar 'mysalt'
  RETURN hashed_password;
END //
DELIMITER ;

-- Crear la tabla encuesta
CREATE TABLE encuesta (
  id_encuesta INT AUTO_INCREMENT PRIMARY KEY,
  Descripcion text NOT NULL,
  data_Creacion date NOT NULL,
  data_finalizacion date NOT NULL,
  id_empresa INT,
  FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa) ON DELETE CASCADE
);

-- Insertar ejemplo de Empresa
INSERT INTO Empresa (nombre) VALUES ('empresa_de_ahmed');

-- Insertar ejemplo de Usuario
INSERT INTO Usuarios (nombre, correo, contrasenya) VALUES ('samir', 'samirseraj03@gmail.com', 'ahmed123');

-- Insertar ejemplo de Enquestador asociado a un Usuario y una Empresa
INSERT INTO enquestadores (localizacion, id_usuarios, id_empresa) VALUES ('girona', 1, 1);

-- Insertar ejemplo de Encuesta asociada a una Empresa
INSERT INTO encuesta (Descripcion, data_Creacion, data_finalizacion, id_empresa) VALUES ('Encuesta de satisfacción', '2024-01-01', '2024-02-01', 1);

-- Insertar ejemplo de Pregunta
INSERT INTO preguntas (enunciado, id_tipus) VALUES ('¿Cómo calificarías nuestro servicio?', 1);

-- Insertar ejemplo de Tipo de Pregunta
-- Ya hemos insertado antes

-- Insertar ejemplo de Preguntes_Enquestes asociando una Pregunta a una Encuesta
INSERT INTO preguntes_enquestes (id_encuesta, id_pregunta) VALUES (1, 1);

-- Insertar ejemplo de Opcion asociada a una Pregunta
INSERT INTO opciones (descripcion, id_tipus) VALUES ('Muy bueno', 1);

-- Insertar ejemplo de Respuesta asociada a una Pregunta y un Usuario
INSERT INTO respuestas (id_pregunta, id_usuarios) VALUES (1, 1);