FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev nodejs npm \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader --prefer-dist

RUN npm install && npm run build

RUN chmod -R 775 storage bootstrap/cache public/build \
    && chown -R www-data:www-data storage bootstrap/cache public/build

EXPOSE 9090

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9090"]
