FROM php:7.2.6-fpm

RUN apt-get update && \
    apt-get install -y libmcrypt-dev git mysql-client libmagickwand-dev --no-install-recommends
RUN pecl install imagick mcrypt-1.0.1
RUN docker-php-ext-enable imagick mcrypt
RUN docker-php-ext-install pdo_mysql zip

RUN curl -sS https://getcomposer.org/installer | php
RUN chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install soap