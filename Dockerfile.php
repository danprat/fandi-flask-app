FROM --platform=linux/arm64 php:8.1-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite headers ssl

# Disable opcache via ini (helps avoid binary mismatch errors)
RUN printf "opcache.enable=0\nopcache.enable_cli=0\n" > /usr/local/etc/php/conf.d/disable-opcache.ini

# Set Apache ServerName to suppress AH00558
RUN printf "ServerName localhost\n" > /etc/apache2/conf-available/servername.conf \
    && a2enconf servername

# Configure Apache to allow .htaccess
RUN printf '<Directory /var/www/html>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' > /etc/apache2/conf-available/htaccess.conf \
    && a2enconf htaccess

# Copy PHP files to web root
COPY . /var/www/html/

# Create uploads directory if it doesn't exist
RUN mkdir -p /var/www/html/uploads

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/ \
    && chmod -R 777 /var/www/html/uploads/

# Expose port 80
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]