FROM php:7.1-fpm

# install PHP dependencies
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
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring gd xml \
    && docker-php-ext-configure gd --with-freetype --with-jpeg

# Install Node.js v10
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash - && \
    apt-get install -y nodejs

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.2.0 && \
    mv composer.phar /usr/local/bin/composer

# Create www user & group and set permissions
ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} www \
    && useradd -u ${UID} -g www -m www
RUN mkdir -p /var/www && chown -R www:www /var/www

# copy workdir www
USER www
WORKDIR /var/www
COPY . /var/www

USER www
EXPOSE 9000
CMD ["php-fpm"]
