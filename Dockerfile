# Використовуємо PHP 8.2 як базовий образ
FROM php:8.2-fpm

# Встановлюємо необхідні системні залежності
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql

# Встановлюємо Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Налаштування робочої директорії
WORKDIR /var/www

# Копіюємо файли проекту
COPY . .

# Налаштовуємо права доступу
RUN chown -R www-data:www-data /var/www

# Експортуємо порт
EXPOSE 9000

# Запускаємо PHP-FPM
CMD ["php-fpm"]
