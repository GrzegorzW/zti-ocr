FROM php:7.1-fpm

RUN apt-get update && apt-get -y --no-install-recommends install \
        git \
        unzip \
        wget \
        vim \
        libpng-dev \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        exif \
        opcache \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && wget -O - https://packagecloud.io/gpg.key | apt-key add - \
    && echo "deb http://packages.blackfire.io/debian any main" | tee /etc/apt/sources.list.d/blackfire.list \
    && apt-get update \
    && apt-get install blackfire-agent \
    && apt-get install blackfire-php \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

WORKDIR /ocr
