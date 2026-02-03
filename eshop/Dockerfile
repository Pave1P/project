FROM php:8.2-apache

# Ставим драйвер для базы данных
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Ставим Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Включаем красивые ссылки
RUN a2enmod rewrite
