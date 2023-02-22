# PHP verstion arguman
ARG PHP_VERSION=8-fpm

# Use php image for base
FROM php:${PHP_VERSION}

# Information about image
LABEL version="1.0.0"

# Envierments
ENV TZ="Asia/Tehran"
ENV APP_NAME="Wallpaper Tank"
ENV APP_ENV="production"
ENV APP_DEBUG="false"

# Change timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin

# Install NodeJS
COPY --from=node:lts /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node:lts /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

# Update System and Install required dependencies
RUN apt-get update -q \
    && apt-get install --no-install-recommends -y -q \
    nano \
    cron \
    supervisor \
    icu-devtools \
    jq \
    libfreetype6-dev libicu-dev libjpeg62-turbo-dev libpng-dev libpq-dev \
    libsasl2-dev libssl-dev libwebp-dev libxpm-dev libzip-dev libzstd-dev \
    unzip \
    zlib1g-dev \
    libonig-dev \
    && apt-get clean \
    && apt-get autoclean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install redis && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-enable opcache redis

# Copy files to images as www-data resource owner
COPY --chown=www-data:www-data . /var/www/laravel
COPY --chmod=+x /docker/entrypoint.sh /entrypoint.sh

WORKDIR /var/www/laravel

EXPOSE 9000
ENTRYPOINT ["/bin/bash","/entrypoint.sh"]
