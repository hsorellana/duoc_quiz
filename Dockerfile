FROM hitalos/laravel:latest

RUN curl -sS https://getcomposer.org/installer | php
RUN chmod +x composer.phar && mv composer.phar /usr/local/bin/composer