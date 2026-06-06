FROM php:8.3-cli

RUN apt-get update && apt-get install -y git unzip libpq-dev libzip-dev zip \
    && docker-php-ext-install pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
