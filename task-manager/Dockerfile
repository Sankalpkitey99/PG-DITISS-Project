# Use PHP-Apache base image
FROM php:7.4-apache

# Install PDO_MySQL extension
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache mod_rewrite (for clean URLs if needed)
RUN a2enmod rewrite

# Copy your app (if not using hostPath)
COPY . /var/www/html/

# Set document root permissions (optional)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80
