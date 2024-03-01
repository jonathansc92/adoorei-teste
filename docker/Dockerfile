FROM php:8.2-apache

WORKDIR /app

# Copy the custom entrypoint script to the container
COPY custom-entrypoint.sh /usr/local/bin/custom-entrypoint
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt update \
    && apt install -y \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo pdo_mysql -j$(nproc) gd zip \
    && a2enmod rewrite headers proxy ssl proxy_http http2 alias \
    && chmod 755 /usr/local/bin/custom-entrypoint \
    && cd /usr/local/bin/ \
    # Install Composer
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    # Finish
    && echo 'End'

ENTRYPOINT [ "custom-entrypoint" ]

WORKDIR /var/www/html