FROM php:8.2-fpm

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    nodejs \
    npm \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
        pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar proyecto
COPY . .

# Dependencias PHP
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# Frontend (Vite)
RUN npm install && npm run build

# Permisos Laravel
RUN chmod -R 775 storage bootstrap/cache public/build \
    && chown -R www-data:www-data storage bootstrap/cache public/build

# Puerto Railway
EXPOSE 9090

# Ejecutar Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9090"]
