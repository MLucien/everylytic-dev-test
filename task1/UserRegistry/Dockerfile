FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Allow the kylekatarnls/update-helper and symfony/thanks plugins
RUN composer config --global allow-plugins.kylekatarnls/update-helper true
RUN composer config --global allow-plugins.symfony/thanks true

# Copy Apache configuration to set ServerName directive
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copy project files to the working directory
COPY . .

# Copy .env.example to .env
COPY .env.example .env

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install project dependencies
RUN composer install --no-interaction --optimize-autoloader

# Generate key
RUN php artisan key:generate

# Clear cache
RUN php artisan cache:clear

# Generate artisan auth 
RUN php artisan make:auth

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage

# # Download and configure phpMyAdmin
# RUN mkdir /var/www/html/phpmyadmin \
#     && curl -L https://www.phpmyadmin.net/downloads/phpMyAdmin-latest-all-languages.tar.gz | tar xz --strip-components=1 -C /var/www/html/phpmyadmin

# Set the document root
# ENV APACHE_DOCUMENT_ROOT /var/www/html/public
# RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
# RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#Watch for changes in the project files
# RUN apt-get update && apt-get install -y inotify-tools

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]