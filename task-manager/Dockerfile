# Use base image
FROM php:7.4-apache

# Install PDO_MySQL extension , PHP Data Objects
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite - avail to enable
RUN a2enmod rewrite

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html
# port
EXPOSE 80
