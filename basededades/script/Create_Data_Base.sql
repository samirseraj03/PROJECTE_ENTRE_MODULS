-- Primero, verifica si la base de datos existe
DO
$$
BEGIN
    IF NOT EXISTS (SELECT FROM pg_database WHERE datname = 'enquestas') THEN
        -- Si no existe, crea la base de datos
        CREATE DATABASE enquestas;
    END IF;
END
$$;

\c newDatabaseName;

CREATE LANGUAGE plpgsql;

CREATE TABLE Empresa (
  id_empresa SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
);

CREATE TABLE enquestadores (
  id_enquestador SERIAL PRIMARY KEY,
  localizacion VARCHAR(255) NOT NULL,
  id_empresa INT REFERENCES Empresa(id_empresa) ON DELETE CASCADE
);

CREATE TABLE agents (
  id_agent SERIAL PRIMARY KEY,
  localizacion VARCHAR(255) NOT NULL,
  id_empresa INT REFERENCES Empresa(id_empresa) ON DELETE CASCADE
);

CREATE TABLE Usuarios (
  id SERIAL PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  correo VARCHAR(255) NOT NULL,
  contrasenya VARCHAR(255) NOT NULL,
  CONSTRAINT correo_valido CHECK (correo ~* '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$'),
  created_at TIMESTAMP WITHOUT TIME ZONE,
  updated_at TIMESTAMP WITHOUT TIME ZONE,
  id_enquestador INT REFERENCES enquestadores(id_enquestador) ON DELETE CASCADE,
  id_agent INT REFERENCES agents(id_agent) ON DELETE CASCADE
);

CREATE EXTENSION IF NOT EXISTS pgcrypto;

CREATE OR REPLACE FUNCTION hash_password(input_text VARCHAR) RETURNS VARCHAR AS $$
BEGIN
  RETURN crypt(input_text, gen_salt('bf', 8));
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION hash_password_trigger_function()
RETURNS TRIGGER AS $$
BEGIN
  NEW.contrasenya := hash_password(NEW.contrasenya);
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER hash_password_trigger
BEFORE INSERT ON Usuarios
FOR EACH ROW
EXECUTE FUNCTION hash_password_trigger_function();

CREATE TABLE encuesta (
  id_encuesta SERIAL PRIMARY KEY,
  Descripcion TEXT NOT NULL,
  data_creacion DATE NOT NULL CHECK (data_creacion >= CURRENT_DATE),
  data_finalizacion DATE NOT NULL CHECK (data_finalizacion >= CURRENT_DATE AND data_finalizacion > data_creacion),
  id_empresa INT REFERENCES Empresa(id_empresa) ON DELETE CASCADE
);

CREATE TABLE tipus_pregunta (
  id_tipus SERIAL PRIMARY KEY,
  tipus VARCHAR(255) NOT NULL
);

INSERT INTO tipus_pregunta (tipus) VALUES
('slider'),
('imagen'),
('text'),
('si/no');

CREATE TABLE preguntas (
  id_pregunta SERIAL PRIMARY KEY,
  enunciado TEXT NOT NULL,
  id_tipus INT REFERENCES tipus_pregunta(id_tipus) ON DELETE CASCADE NOT NULL
);

CREATE TABLE preguntes_enquestes (
  id_preguntes_enquestes SERIAL PRIMARY KEY,
  id_encuesta INT REFERENCES encuesta(id_encuesta) ON DELETE CASCADE NOT NULL,
  id_pregunta INT REFERENCES preguntas(id_pregunta) ON DELETE CASCADE NOT NULL
);

CREATE TABLE opciones (
  id_opcion SERIAL PRIMARY KEY,
  descripcion TEXT,
  id_pregunta INT REFERENCES preguntas(id_pregunta) ON DELETE CASCADE NOT NULL
);

CREATE TABLE respuestas (
  id_respuesta SERIAL PRIMARY KEY,
  data_resposta TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL CHECK (data_resposta >= CURRENT_TIMESTAMP),
  id_pregunta INT REFERENCES preguntas(id_pregunta) ON DELETE CASCADE NOT NULL,
  id_usuario INT REFERENCES Usuarios(id) ON DELETE CASCADE NOT NULL
);

CREATE TABLE informes (
  id_informe SERIAL PRIMARY KEY,
  usuario INT REFERENCES Usuarios(id) ON DELETE CASCADE,
  enquesta INT REFERENCES encuesta(id_encuesta) ON DELETE CASCADE,
  company INT REFERENCES Empresa(id_empresa) ON DELETE CASCADE,
  n_preguntas INT
);

CREATE TABLE informe_encuestas (
  id SERIAL PRIMARY KEY,
  id_encuesta INT,
  id_pregunta INT,
  tipo_pregunta VARCHAR(255),
  cantidad_respuestas INT
);

-- Insertar ejemplo de Empresa
INSERT INTO Empresa (nombre) VALUES ('Addon');

-- Insertar ejemplo de Enquestador asociado a un Usuario y una Empresa
INSERT INTO enquestadores (localizacion, id_empresa) VALUES ('girona', 1);

-- Insertar ejemplo de Usuario
INSERT INTO usuarios (nombre, correo, contrasenya, id_enquestador, id_agent) VALUES ('samir', 'samirseraj03@gmail.com', 'ahmed123', 1, NULL);

-- Insertar ejemplo de Encuesta asociada a una Empresa
INSERT INTO encuesta (Descripcion, data_creacion, data_finalizacion, id_empresa) VALUES ('Encuesta de satisfacción', '2024-01-01', '2024-02-01', 1);

-- Insertar ejemplo de Pregunta
INSERT INTO preguntas (enunciado, id_tipus) VALUES ('¿Cómo calificarías nuestro servicio?', 1);

-- Insertar ejemplo de Preguntes_Enquestes asociando una Pregunta a una Encuesta
INSERT INTO preguntes_enquestes (id_encuesta, id_pregunta) VALUES (1, 1);

-- Insertar ejemplo de Opcion asociada a una Pregunta
INSERT INTO opciones (descripcion, id_pregunta) VALUES ('Muy bueno', 1);

-- Insertar ejemplo de Respuesta asociada a una Pregunta y un Usuario
--INSERT INTO respuestas (id_pregunta, id_usuario) VALUES (1, 1);
