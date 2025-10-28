FROM php:8.1-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo pdo_pgsql pgsql pdo_mysql mbstring zip exif pcntl gd && \
    pecl install swoole && docker-php-ext-enable swoole && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www && \
 useradd -u 1000 -ms /bin/bash -g www www && \
 chown -R www:www /var/www
USER www

WORKDIR /var/www

COPY --chown=www:www . /var/www

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN php artisan optimize:clear

EXPOSE 8000

CMD ["php", "artisan", "octane:start", "--server=swoole", "--host=0.0.0.0", "--port=8000"]
