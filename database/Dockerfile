# syntax=docker/dockerfile:1

#* Create a database stage for setting up the database.
FROM mariadb:lts
COPY ./start-scripts/ /docker-entrypoint-initdb.d/
