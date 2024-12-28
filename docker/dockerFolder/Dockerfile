# Use the official PHP image as base
FROM php:8.2.4-apache

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock package.json ./

RUN apt-get update

RUN apt-get install -y \
    git \
    nano \
    libpng-dev \
    libmcrypt-dev \ 
    libpq-dev \
    libzip-dev \
    zlib1g-dev \
    zip \
    unzip &&\
    a2enmod rewrite

RUN docker-php-ext-install pdo &&\
    docker-php-ext-install pdo_mysql &&\
    docker-php-ext-install pdo_pgsql &&\
    docker-php-ext-install zip &&\
    docker-php-ext-install gd &&\
    docker-php-ext-install pcntl &&\
    docker-php-ext-install pdo pdo_pgsql pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Copiar el contenido del proyecto al contenedor
COPY . /var/www/html

# Establecer los permisos correctos para los archivos
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copy the rest of the application code
COPY . .

RUN composer update  

# Install dependencies
RUN composer install    --optimize-autoloader

# Habilitar el mod_rewrite de Apache para que Laravel funcione correctamente
RUN a2enmod rewrite




# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]


CMD php artisan serve --host=0.0.0.0 --port=8000 
# Migrate Laravel Postgres

