FROM php:8.1-apache

RUN apt-get update

RUN apt-get install -y \
    pkg-config  \
    libzip-dev libmemcached-dev \
    && pecl install swoole \
    && pecl install memcached-3.2.0 \
    && docker-php-ext-enable memcached swoole \
    && curl -sLS https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm \
    && apt-get update

RUN docker-php-ext-install \
    mysqli \
    pdo_mysql \
    zip

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN a2enmod rewrite
RUN service apache2 restart
