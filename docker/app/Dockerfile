FROM php:8.2-fpm

# Extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Outils utiles
RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*
