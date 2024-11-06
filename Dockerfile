FROM php:cli

RUN apt update
RUN apt install unzip curl libfreetype6-dev libjpeg62-turbo-dev libpng-dev -y

# Uncomment the following lines to activate the GD extension to try local images generation
#RUN docker-php-ext-configure gd --with-freetype --with-jpeg
#RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer -o /usr/local/composer-setup.php

RUN php /usr/local/composer-setup.php --install-dir=/usr/local/bin --filename=composer

RUN rm /usr/local/composer-setup.php
