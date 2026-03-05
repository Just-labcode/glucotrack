FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    curl zip unzip git \
    && docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN touch database/database.sqlite

EXPOSE 8080

CMD php artisan migrate --force && php -S 0.0.0.0:8080 -t public