FROM php:8.5-apache

RUN apt-get update && apt-get install -y \
    git unzip zip curl nodejs npm \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN npm install
RUN npm run build

RUN a2enmod rewrite

RUN sed -i 's!/var/www/html!/app/public!g' /etc/apache2/sites-available/000-default.conf

CMD apache2-foreground