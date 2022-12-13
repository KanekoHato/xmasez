FROM php:8-apache

RUN a2enmod rewrite

COPY . /var/www/html/

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install pdo pdo_mysql
RUN chown -R www-data:www-data *
RUN chmod -R +x *

USER www-data:www-data
