FROM php:8.3-fpm

# Installer dépendances système et extensions PHP nécessaires à Symfony
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev libpq-dev libzip-dev zip \
    mariadb-client \
    && docker-php-ext-install intl pdo pdo_mysql opcache zip

# Installer Xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html
