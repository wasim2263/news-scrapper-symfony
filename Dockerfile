# Dockerfile
FROM php:7.4-cli

RUN apt-get update -y && apt-get install -y \
	libmcrypt-dev \
	libzip-dev \
	libonig-dev \
    librabbitmq-dev
#    && pecl install amqp



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp
RUN docker-php-ext-install pdo_mysql mbstring zip exif

WORKDIR /app
COPY . /app

RUN composer install;

EXPOSE 8000
