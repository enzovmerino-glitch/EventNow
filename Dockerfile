FROM php:8.4-apache

RUN docker-php-ext-install pdo_mysql \
    && rm /usr/local/etc/php/conf.d/docker-php-ext-pdo_mysql.ini \
    && a2enmod rewrite

COPY docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY app/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
