FROM php:8.2-apache

# Enable Apache mod_rewrite (useful for clean URLs/routing)
RUN a2enmod rewrite

# Install common PHP database extensions (uncomment what you need)
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy your project files into the Apache web root
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
