FROM php:8.3-apache

RUN a2enmod rewrite

RUN apt-get update -y

RUN docker-php-ext-install mysqli pdo_mysql

