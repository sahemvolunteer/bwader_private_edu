FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# انسخ المشروع بالكامل أول
COPY . .

# بعدها شغّل composer install
RUN composer install --no-dev --optimize-autoloader -vvv

# ضبط صلاحيات
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
