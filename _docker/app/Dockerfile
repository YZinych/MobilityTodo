# Використовуємо офіційний образ PHP 7.1 FPM
FROM php:7.1-fpm

# Встановлюємо робочу директорію
WORKDIR /var/www

# Встановлюємо системні залежності та розширення PHP
RUN apt-get update && apt-get install -y \
    mc \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libmcrypt-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring gd xml \
    && docker-php-ext-configure gd --with-freetype --with-jpeg

# Завантажуємо і встановлюємо Composer 2.2 LTS
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.2.0 && \
    mv composer.phar /usr/local/bin/composer

# Встановлюємо Laravel через Composer у піддиректорію "laravel"
# RUN composer create-project --prefer-dist laravel/laravel . "5.3.*"

# Встановлюємо права для правильного доступу до файлів
#RUN chown -R www-data:www-data /var/www/laravel \
#    && chmod -R 755 /var/www/laravel

# Порт, який буде використовувати PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
