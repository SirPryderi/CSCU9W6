FROM php:7.2.3-apache

#RUN apt-get update \
#    && apt-get install -y --no-install-recommends \
#    libicu-dev \
#    zlib1g-dev \
#    libpq-dev \
#    libzip-dev \
#    libpcre3-dev \
#    ssmtp vim git cron zip \
#    && docker-php-ext-install \
#    pdo \
#    pdo_pgsql \
#    zip

RUN apt-get update && \
    apt-get install -y --no-install-recommends libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

RUN echo "extension=php_pgsql.so" > $PHP_INI_DIR/conf.d/php_pgsql.ini

RUN a2enmod rewrite && service apache2 restart

COPY docker-images/web/php.ini /usr/local/etc/php/

RUN service apache2 restart