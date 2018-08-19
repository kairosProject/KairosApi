FROM php:7.2-apache

RUN apt-get update
RUN apt-get install -y autoconf build-essential git zip unzip zlib1g-dev
RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

RUN apt-get install -y libsodium-dev libicu-dev
RUN docker-php-ext-install sodium opcache mbstring intl zip

ENV APP_ENV=dev
ENV APP_DEBUG=1

ADD http://xdebug.org/files/xdebug-2.6.0.tgz /tmp
WORKDIR /tmp
RUN tar -xvzf xdebug-2.6.0.tgz
WORKDIR /tmp/xdebug-2.6.0
RUN phpize
RUN ./configure
RUN make
RUN cp modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718
RUN echo "zend_extension = /usr/local/lib/php/extensions/no-debug-non-zts-20170718/xdebug.so" >> /usr/local/etc/php/php.ini

WORKDIR /var/www/html/
RUN rm -rf /var/lib/apt/lists/*
