# PROJECTE_ENTRE_MODULS


INSTALAR POSTGRESSQL 
cuando postgres este encendido 
ejucutar este comando :apt update y luego apt install pgagent

ejucutar el script dentro de la base de datos de sql

https://www.enterprisedb.com/blog/pgagent-setup

seguir el tutorial


https://docs.aidbox.app/readme-1/administration/working-with-pgagent


GRANT USAGE ON SCHEMA pgagent TO postgres;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA pgagent TO postgres;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA pgagent TO postgres;
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO postgres;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO postgres;