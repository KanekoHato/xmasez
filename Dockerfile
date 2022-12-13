FROM php:8-apache

RUN a2enmod rewrite

COPY * /var/www/html/

RUN chown -R www-data:www-data *
RUN chmod -R +x *

USER www-data:www-data
