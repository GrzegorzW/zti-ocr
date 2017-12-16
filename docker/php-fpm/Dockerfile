FROM php:7.1-fpm

RUN apt-get update && apt-get -y --no-install-recommends install \
        git \
        unzip \
        wget \
        vim \
        libpng-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        exif \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /ocr
