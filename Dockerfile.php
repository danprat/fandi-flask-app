FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli

# Disable opcache via ini (helps avoid binary mismatch errors)
RUN printf "opcache.enable=0\nopcache.enable_cli=0\n" > /usr/local/etc/php/conf.d/disable-opcache.ini

# Set Apache ServerName to suppress AH00558
RUN printf "ServerName localhost\n" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# Copy PHP files to web root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80