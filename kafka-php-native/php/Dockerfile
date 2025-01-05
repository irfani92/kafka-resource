FROM php:8.0-fpm

WORKDIR /var/www/html

COPY . .

RUN apt-get update && \
    apt-get install -y librdkafka-dev && \
    rm -rf /var/lib/apt/lists/*

RUN pecl channel-update pecl.php.net
RUN pecl uninstall rdkafka 
RUN pecl install rdkafka
RUN docker-php-ext-enable rdkafka

EXPOSE 87