# syntax=docker/dockerfile:1

ARG PHP_VERSION=8.4
ARG NODE_VERSION=22
ARG COMPOSER_VERSION=2

FROM composer:${COMPOSER_VERSION} AS composer-bin

# -----------------------------------------------------------------------------
# Frontend (Vite + Tailwind)
# -----------------------------------------------------------------------------
FROM node:${NODE_VERSION}-alpine AS assets

WORKDIR /app

COPY package.json ./
RUN npm install --no-audit --no-fund

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build

# -----------------------------------------------------------------------------
# PHP base: extensões exigidas pelo Laravel 12 + Postgres/SQLite
# -----------------------------------------------------------------------------
FROM php:${PHP_VERSION}-cli-alpine AS php-base

RUN apk add --no-cache \
        bash \
        curl \
        icu-libs \
        libpq \
        libzip \
        postgresql-client \
        sqlite \
        su-exec \
        unzip \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        postgresql-dev \
        sqlite-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        intl \
        opcache \
        pcntl \
        pdo_pgsql \
        pdo_sqlite \
        zip \
    && apk del .build-deps \
    && addgroup -g 1000 app \
    && adduser -D -G app -u 1000 -h /home/app app

COPY --from=composer-bin /usr/bin/composer /usr/bin/composer
COPY docker/php.ini /usr/local/etc/php/conf.d/99-taskflow.ini
COPY docker/entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

WORKDIR /var/www/html

ENV COMPOSER_HOME=/tmp/composer \
    PATH="/var/www/html/vendor/bin:${PATH}"

EXPOSE 8000
ENTRYPOINT ["docker-entrypoint"]

# -----------------------------------------------------------------------------
# Desenvolvimento: o código é montado pelo docker-compose
# -----------------------------------------------------------------------------
FROM php-base AS development

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

# -----------------------------------------------------------------------------
# Produção / imagem autocontida (CI, demonstração sem volume)
# -----------------------------------------------------------------------------
FROM php-base AS production

COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --no-scripts \
        --prefer-dist

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R app:app /var/www/html

USER app

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
