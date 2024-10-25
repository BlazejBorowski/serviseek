# Build Stage
FROM php:8.3-fpm AS build

ENV APP_HOME /var/www/app
WORKDIR $APP_HOME

COPY --chown=www-data:www-data . .

COPY --from=composer:2.8.1 /usr/bin/composer /usr/bin/composer

RUN cp .env.docker .env \
    && apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
    && composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build \
    && php artisan optimize \
    && npm prune --production \
    && rm -rf node_modules/.cache

# Final Stage
FROM php:8.3-fpm AS final

ENV APP_HOME /var/www/app
WORKDIR $APP_HOME

COPY --from=build /var/www/app .

RUN apt-get update && apt-get install -y \
        zip \
        unzip \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libcurl4-gnutls-dev \
        nginx \
    && docker-php-ext-install pdo_mysql mbstring opcache curl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && addgroup --system --gid 1000 customgroup \
    && adduser --system --ingroup customgroup --uid 1000 customuser \
    && chown -R customuser:customgroup $APP_HOME

# disable root user
RUN passwd -l root \
    && usermod -s /usr/sbin/nologin root

USER customuser

RUN php artisan key:generate

EXPOSE 9000

ENTRYPOINT ["/var/www/app/docker/app/entrypoint.sh"]
