FROM php:8.4-fpm

RUN apt-get update && apt-get install -y iputils-ping ca-certificates git
RUN apt-get install -y libcurl4 libcurl4-openssl-dev libxml2-dev libz-dev libonig-dev libzip-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) pdo mysqli intl curl pdo_mysql zip

# Install recommended extensions for Symfony
RUN apt-get update && apt-get install -y \
        libicu-dev \
    && docker-php-ext-install \
        intl \
    && docker-php-ext-enable \
        intl

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer