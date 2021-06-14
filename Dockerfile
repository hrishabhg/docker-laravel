FROM php:8.0.7-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

#Install xdebug
RUN pecl install xdebug-3.0.4 && docker-php-ext-enable xdebug

#set laravel storage ownership
RUN chown -R www-data:www-data /var/www/html/storage/

# Set working directory
WORKDIR /var/www