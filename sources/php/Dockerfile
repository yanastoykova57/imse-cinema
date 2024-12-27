FROM php:8.1-apache

RUN apt-get update && apt-get install -y \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite

#installing composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

#COPY . /var/www/html/

WORKDIR /var/www/html/

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY . .

RUN chown -R www-data:www-data /var/www/html/

#(optional install composer)
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#(optional dependencies composer)
# RUN composer install

#COPY composer.json composer.lock /var/www/html/
#RUN if [ -f composer.json ]; then composer install; fi