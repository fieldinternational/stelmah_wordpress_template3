FROM php:8.1-fpm

RUN apt-get update \
    && apt-get -y install vim wget lsb-release libicu-dev mariadb-client git zip unzip libpng-dev libsodium-dev libzip-dev libjpeg-dev libfreetype6-dev libssl-dev libxrender-dev libfontconfig fonts-ipafont g++ \
    && docker-php-ext-install pdo_mysql mysqli intl pcntl sodium gd zip sockets

RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd


RUN apt-get update && \
    apt-get install -y libpq-dev && \
    rm -rf /var/lib/apt/lists/*

COPY ./docker/php/php-fpm.d/zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/php.ini
