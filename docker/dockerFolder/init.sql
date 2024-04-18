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

\c enquestas;


-- Concede permisos SELECT en todas las tablas de la base de datos "enquestas" al usuario "usuario":
GRANT SELECT ON ALL TABLES IN SCHEMA public TO postgres;

-- Concede permisos INSERT, UPDATE y DELETE en todas las tablas de la base de datos "enquestas" al usuario "usuario":
GRANT INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO postgres;

-- Concede permisos USAGE en todas las secuencias de la base de datos "enquestas" al usuario "usuario":
GRANT USAGE ON ALL SEQUENCES IN SCHEMA public TO postgres;

-- Concede todos los permisos en todas las tablas y secuencias de la base de datos "enquestas" al usuario "usuario":
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO postgres;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO postgres;



DO $$ 
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_language WHERE lanname = 'plpgsql') THEN
        -- Crea el lenguaje PL/pgSQL si no existe
        CREATE LANGUAGE plpgsql;
    END IF;
END $$;

CREATE TABLE empresa(
  id_empresa serial PRIMARY KEY,
  nombre varchar(255) NOT NULL
);

CREATE TABLE enquestadores (

 id_enquestadores serial PRIMARY key,
 localizacion VARCHAR(255) not null,
 id_empresa INT REFERENCES empresa(id_empresa) ON DELETE CASCADE

);

CREATE TABLE agents (

 id_agents serial PRIMARY key,
 localizacion VARCHAR(255) not null,
 id_empresa INT REFERENCES empresa(id_empresa) ON DELETE CASCADE

);

CREATE TABLE usuarios(

  id serial PRIMARY KEY,
  nombre varchar(255) NOT NULL,
  correo VARCHAR(255) NOT null,
  contrasenya VARCHAR(255) NOT null,
 CONSTRAINT correo_valido CHECK (correo ~* '^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$'),
 created_at TIMESTAMP WITHOUT TIME ZONE ,
 updated_at  TIMESTAMP WITHOUT TIME ZONE,
 id_enquestadores  INT REFERENCES enquestadores(id_enquestadores) ON DELETE CASCADE ,
 id_agents INT REFERENCES agents(id_agents) ON DELETE CASCADE

 

);


-- Asegúrate de que la extensión pgcrypto esté habilitada
DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_extension WHERE extname = 'pgcrypto') THEN
        -- Crea la extensión pgcrypto si no existe
        CREATE EXTENSION pgcrypto;
    END IF;
END $$;
-- Crear la función hash_password
-- CREATE OR REPLACE FUNCTION hash_password(input_text VARCHAR) RETURNS VARCHAR AS $$
-- BEGIN
--   RETURN ENCODE(DIGEST(input_text || gen_salt('md5'), 'md5'), 'hex');
-- END;
-- $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION hash_password(input_text VARCHAR) RETURNS VARCHAR AS $$
BEGIN
  RETURN crypt(input_text, gen_salt('bf', 8));  -- Usa la función crypt() con el formato 'bf' para bcrypt
END;
$$ LANGUAGE plpgsql;

-- Create a trigger to automatically hash the password before inserting a new row
CREATE OR REPLACE FUNCTION hash_password_trigger_function()
RETURNS TRIGGER AS $$
BEGIN
  NEW.contrasenya := hash_password(NEW.contrasenya);
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE TRIGGER hash_password_trigger
BEFORE INSERT ON usuarios
FOR EACH ROW
EXECUTE FUNCTION hash_password_trigger_function();


CREATE TABLE encuesta (
  id_encuesta serial PRIMARY KEY,
  Descripcion text NOT NULL,
  data_Creacion date NOT NULL CHECK (data_Creacion >= CURRENT_DATE),
  data_finalizacion date NOT NULL CHECK (data_finalizacion >= CURRENT_DATE AND data_finalizacion > data_Creacion),
  id_empresa INT REFERENCES empresa(id_empresa) ON DELETE CASCADE

);


CREATE table tipus_pregunta(
    id_tipus serial PRIMARY key,
    tipus varchar(255) not null

);



CREATE TABLE preguntas (
id_pregunta serial PRIMARY key,
id_encuesta int REFERENCES encuesta(id_encuesta) ON DELETE CASCADE not null,
enunciado text not  null ,
id_tipus int REFERENCES tipus_pregunta(id_tipus) ON DELETE CASCADE not null

);


CREATE TABLE opciones(
id_opcion serial PRIMARY key,
descripcion text,
id_pregunta INT REFERENCES preguntas(id_pregunta)
);


CREATE TABLE respuestas (

  id_respuesta serial PRIMARY KEY,
  data_resposta TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL CHECK (data_resposta >= CURRENT_TIMESTAMP),
  id_pregunta int REFERENCES preguntas(id_pregunta) ON DELETE CASCADE not null,
  id_usuarios int  REFERENCES usuarios(id) ON DELETE CASCADE not null

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
INSERT INTO empresa ( id_empresa  ,  nombre) VALUES ( 1 , 'empresa_de_ahmed');

-- Insertar ejemplo de Usuario
insert into usuarios ( id ,nombre , correo , contrasenya) values ( 1 , 'samir' , 'samirseraj03@gmail.com' , 'ahmed123');

-- Insertar ejemplo de Enquestador asociado a un Usuario y una Empresa
INSERT INTO enquestadores (id_enquestadores, localizacion, id_empresa) VALUES (1, 'girona', 1);

INSERT INTO tipus_pregunta (id_tipus , tipus) VALUES
(1 , 'text'),
(2, 'date'),
(3 , 'email'),
(4, 'select'),
(5 , 'checkbox'),
(6, 'radio'),
(7, 'textarea'),
(8, 'number');

-- Insertar ejemplo de Encuesta asociada a una Empresa
INSERT INTO encuesta (id_encuesta , Descripcion, data_Creacion, data_finalizacion, id_empresa) 
VALUES ( 1 , 'Encuesta de satisfacción', '2025-03-14', '2025-04-14', 1),
	(2, 'Formulari2', '2025-03-23', '2025-05-26', 1);;

	
INSERT INTO public.preguntas(id_pregunta, id_encuesta,
	enunciado, id_tipus)
	VALUES 
	(1, 1, 'Quin és el teu nom?', 1),
	(2, 1, 'Quants anys tens?', 8),
	(3, 1, 'De quina ciutat ets?', 1),
	(4, 1, 'Quin és el teu àmbit de interes personal',4),
	(5, 2, 'Quin és el teu nom complet?', 1),
	(6, 2, 'Quina és la teva data de naixement?', 2),
	(7, 2, 'Quin és el teu correu electrònic?', 3),
	(8, 2, 'Quina és la teva ocupació actual?', 4),
	(9, 2, 'Quins són els teus interessos? (Selecciona tot el que correspongui)', 5),
	(10, 2, 'Quin és el teu gènere?', 6),
	(11, 2, 'Tens algun comentari o suggeriment?', 7);

INSERT INTO public.opciones(
	id_opcion, descripcion, id_pregunta)
	VALUES (1, 'Escriu el teu nom aquí' , 1),
	(2, 'Escriu la teva edat aquí', 2),
	(3, 'Escriu la teva ciutat aquí', 3),
	(4, 'Tecnologia', 4),
	(5, 'Esports', 4),
	(6, 'Música', 4),
	(7, 'Art', 4),
	(8, 'Ciència', 4),
	(9, 'Escriu el teu nom complet aquí', 5),
	(10, 'Selecciona la teva data de naixement', 6),
	(11, 'Escriu el teu correu electrònic aquí', 7),
	(12, 'Estudiant', 8),
	(13, 'Professional', 8),
	(14, 'Autònom', 8),
	(15, 'Desocupat', 8),
	(16, 'Altres', 8),
	(17, 'Esports', 9),
	(18, 'Viages', 9),
	(19, 'Cinema', 9),
	(20, 'Tecnologia', 9),
	(21, 'Cuina', 9),
	(22, 'Tecnologia', 9),
	(23, 'Femení', 10),
	(24, 'Masculí', 10),
	(25, 'No binari', 10),
	(26, 'Prefereixo no dir-ho', 10),
	(27, 'Escriu els teus comentaris aquí', 11);
