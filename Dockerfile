# Dockerfile for running PHBN Traders PHP website on Render / Docker environments
FROM php:8.2-apache

# Install SQLite3 and PDO extensions for database support
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    && docker-php-ext-install pdo_sqlite pdo_mysql

# Enable Apache mod_rewrite & AllowOverride All for .htaccess SEO routes
RUN a2enmod rewrite && sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy project files into Apache document root
COPY . /var/www/html/

# Ensure write permissions for SQLite database storage directory
RUN mkdir -p /var/www/html/data \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/data

# Run database setup script to initialize SQLite tables & seed demo data
RUN php /var/www/html/setup.php

EXPOSE 80

CMD ["apache2-foreground"]
