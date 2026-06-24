# FROM php:8.2-cli
# # Install dependency
# RUN apt-get update && apt-get install -y \
#     git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev

# RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl
# # Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# WORKDIR /app
# COPY . .
# RUN composer install --no-dev --optimize-autoloader
# # Laravel config
# EXPOSE 10000
# CMD php artisan migrate --force && \
#     php artisan config:cache && \
#     php artisan serve --host=0.0.0.0 --port=10000

FROM php:8.2-cli

# Install dependency
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpng-dev libonig-dev libxml2-dev nodejs npm

RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Install & build Vite
RUN npm install
RUN npm run build

EXPOSE 10000

CMD php artisan config:clear && \
    php artisan config:cache && \
    php artisan serve --host=0.0.0.0 --port=10000
