FROM php:8.2-apache

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_mysql curl

# Copiar todos los archivos de la aplicacion
COPY . /var/www/html/

# Dar permisos correctos
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80