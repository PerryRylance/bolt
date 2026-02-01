# NB: Some packages only support up to 8.4 at the moment
FROM php:8.4-cli
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions gd xdebug intl dom xml simplexml zip pdo_mysql pdo_pgsql pgsql pdo_sqlite pdo_sqlsrv sqlsrv

COPY ./xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini

WORKDIR /usr/src/app

COPY . .
