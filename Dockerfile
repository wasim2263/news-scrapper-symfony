# Dockerfile
FROM php:7.4-cli

RUN apt-get update -y && apt-get install -y \
	libmcrypt-dev \
	libzip-dev \
	libonig-dev 



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

WORKDIR /app
COPY . /app

RUN composer install

EXPOSE 8000
