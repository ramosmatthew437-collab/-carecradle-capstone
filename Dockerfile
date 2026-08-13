FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    nodejs npm \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --optimize-autoloader --no-dev

RUN npm install
RUN npm run build

CMD php artisan serve --host=0.0.0.0 --port=$PORT