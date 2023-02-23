FROM composer:latest
WORKDIR /usr/local/src

COPY . .

RUN composer install