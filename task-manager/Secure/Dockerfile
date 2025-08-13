FROM php:8.1-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod ssl rewrite

RUN a2dissite 000-default

#RUN rm /etc/apache2/sites-enabled/000-default.conf

COPY apache-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Copy application code to web root
COPY . /var/www/html/

# Set file permissions
RUN chown -R www-data:www-data /var/www/html

# Copy SSL certificates and key
COPY xcaProject/taskmanager.did.lab.crt /etc/ssl/certs/server.crt
COPY xcaProject/sslcert-key-pvk.pem /etc/ssl/private/server.key
COPY xcaProject/taskmanager.did.lab.pem /etc/ssl/certs/server-chain.pem

# Set appropriate permissions on certs
RUN chmod 600 /etc/ssl/private/server.key && chmod 644 /etc/ssl/certs/server.crt


EXPOSE 443
