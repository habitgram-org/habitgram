FROM php:8.4-fpm

ARG APP_ENV

ENV UID=33 \
    GID=33

# Install system dependencies, PHP extensions, and clean up in single layer
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get update && apt-get clean && apt-get install -y \
        build-essential \
        cron \
        curl \
        gifsicle \
        git \
        graphviz \
        jpegoptim \
        libavif-bin \
        libfreetype6-dev \
        libjpeg-dev \
        libonig-dev \
        libpng-dev \
        libpq-dev \
        libsodium-dev \
        libuv1-dev \
        libxml2-dev \
        libzip-dev \
        libicu-dev \
        nginx \
        nodejs \
        optipng \
        pngquant \
        qpdf \
        supervisor \
        unzip \
        zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    npm install -g svgo --ignore-scripts && \
    pecl install redis && \
    pecl install channel://pecl.php.net/uv-0.3.0 && \
    docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ && \
    docker-php-ext-install bcmath exif gd intl mbstring opcache pcntl pdo pdo_pgsql sodium xml zip && \
    docker-php-ext-enable opcache pcntl redis uv && \
    mkdir -p /var/www/html

# Copy configuration files
COPY .docker/nginx/default.conf /etc/nginx/sites-available/default
COPY .docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini
COPY .docker/supervisor/conf.d/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY entrypoint.sh /usr/local/bin/

# Setup entrypoint and cron
RUN chmod 755 /usr/local/bin/entrypoint.sh && \
    ln -s /usr/local/bin/entrypoint.sh / && \
    touch /var/log/cron.log

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY --chown=www-data:www-data . .

RUN echo 'alias a="php artisan"' >> ~/.bashrc

COPY .docker/cron/cronjob /etc/cron.d/cronjob

RUN chmod 644 /etc/cron.d/cronjob
RUN crontab /etc/cron.d/cronjob

ENTRYPOINT ["entrypoint.sh"]

CMD ["php-fpm"]
