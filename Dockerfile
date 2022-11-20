# Dockerfile
FROM php:7.4-cli

RUN apt-get update -y && apt-get install -y \
	libmcrypt-dev \
	libzip-dev \
	libonig-dev \
    librabbitmq-dev \
    libnss3 \
    libnspr4 \
    libatk1.0-0  \
    libatk-bridge2.0-0 \
    libcups2  \
    libdrm2 \
    libxkbcommon0 \
    libxcomposite1  \
    libxdamage1 \
    libxfixes3 \
    libxrandr2  \
    libgbm1 \
    libasound2 \
    chromium \
    chromium-driver \
    cron \
    vim

#    && pecl install amqp



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp
RUN docker-php-ext-install pdo_mysql mbstring zip exif

WORKDIR /app
COPY . /app

RUN composer install;

ENV PANTHER_NO_SANDBOX 1
ENV PANTHER_CHROME_ARGUMENTS='--disable-dev-shm-usage --disable-gpu --disable-extensions --remote-debugging-port=9222'

#RUN echo "*/5 * * * * root php /app/bin/console  app:scrap-news >> /var/log/cron.log 2>&1" >> /etc/crontab

COPY my-crontab /etc/cron.d/my-crontab
RUN chmod 0644 /etc/cron.d/my-crontab && crontab /etc/cron.d/my-crontab
RUN touch /var/log/cron.log
EXPOSE 8000
