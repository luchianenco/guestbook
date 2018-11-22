FROM php:7.2-fpm-stretch
RUN apt-get clean && apt-get update && apt-get install -y zlib1g-dev libicu-dev g++ unzip
RUN docker-php-ext-install -j$(nproc) opcache zip pdo pdo_mysql mbstring

RUN pecl install xdebug-2.6.0 && docker-php-ext-enable xdebug pdo_mysql pdo mbstring

# Clear Temp Pear Folder
RUN rm -rf /tmp/pear

RUN echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN echo 'date.timezone = "Europe/Berlin"' >> /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app
