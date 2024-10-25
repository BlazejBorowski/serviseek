FROM php:8.3-fpm as php

# ENV COMPOSER_HOME=/var/www/.composer
# ENV NPM_CONFIG_CACHE=/var/www/.npm

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        gnutls-dev \
        autoconf \
        bash \
        curl \
        git \
        libpq-dev \
        libcurl4-gnutls-dev \
        nginx

RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd opcache curl

ENV APP_HOME /var/www/app
WORKDIR $APP_HOME

RUN addgroup --system --gid 1000 customgroup \
    && adduser --system --ingroup customgroup --uid 1000 customuser

COPY --chown=customuser:customgroup . .

COPY --from=composer:2.8.1 /usr/bin/composer /usr/bin/composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

# RUN chmod +w /var/www/app/public
# RUN chown -R customuser:customgroup /var /run

# disable root user
RUN passwd -l root
RUN usermod -s /usr/sbin/nologin root

USER customuser

RUN php artisan key:generate

ENTRYPOINT ["/var/www/app/docker/app/entrypoint.sh"]
