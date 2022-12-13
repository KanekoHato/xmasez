FROM php:8-apache

RUN a2enmod rewrite

COPY . /var/www/html/

RUN docker-php-ext-install pdo pdo_mysql
RUN chown -R www-data:www-data *
RUN chmod -R +x *
