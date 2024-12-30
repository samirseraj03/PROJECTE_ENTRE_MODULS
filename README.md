# Guía para Ejecutar la Aplicación con Docker

Este proyecto utiliza Docker para contenerizar una aplicación que emplea **Laravel** como backend y frontend, y **PostgreSQL** como sistema de gestión de base de datos. Sigue los pasos a continuación para encender la aplicación de manera rápida y sencilla.

## Requisitos Previos

Antes de comenzar, asegúrate de tener lo siguiente instalado en tu máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

Si ya tienes estas herramientas instaladas, puedes continuar con los siguientes pasos.

## Pasos para Ejecutar la Aplicación

1. **Clonar el repositorio**

    Si aún no has clonado el repositorio de la aplicación, puedes hacerlo ejecutando el siguiente comando:

    ```bash
    git clone https://github.com/samirseraj03/RecollirEnquestesEnPHP.git
    cd RecollirEnquestesEnPHP

    cp .env.example .env

    DB_CONNECTION=pgsql
    DB_HOST=postgres
    DB_PORT=5432
    DB_DATABASE=nombre_de_base_de_datos
    DB_USERNAME=usuario
    DB_PASSWORD=contraseña

    docker-compose -f docker/dockerFolder/docker-compose.yml up --build



### Explicación de los cambios:

- He agregado los pasos para copiar el archivo `.env` desde `.env.example` y configurarlo con las credenciales de la base de datos PostgreSQL.
- El comando `docker-compose -f docker/dockerFolder/docker-compose.yml up --build`  indicando cómo levantar los contenedores para Laravel y PostgreSQL.

Este `README.md` proporciona una guía completa y clara para ejecutar la aplicación, desde la configuración de las variables de entorno hasta el inicio de los contenedores Docker y la migración de la base de datos.



# OTRA ALTERNATIVA PARA PONER EN MARCHA LAS IMAGENES 

    - Desgarga docker y docker compose y crea este archivo y poniendo lo siguente:

    ```bash    
        services:
          laravel:
            image: mserajdam/laravel-app:latest
            ports:
              - "80:8000"
            networks:
              - db-network  # Add the network here
        
          postgres:
            image: mserajdam/postgres-db:latest
            container_name: postgres_container
            ports:
              - "5432:5432"
            networks:
              - db-network  # Add the network here
        
        networks:
          db-network:
            driver: bridge  # Define the network

    - finalmente docker-compose up -d






### Notas importantes
    Reiniciar el proceso de registro: simplemente repite el proceso de registro hasta que se complete correctamente. En algunos casos, un segundo o tercer intento será exitoso.

    se puede testear a traves test@test.com:test123
