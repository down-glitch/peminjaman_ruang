# Gunakan image PHP resmi yang sudah disertakan web server
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin file aplikasi, kecuali folder yang tidak perlu
COPY . /var/www/html

# Set permission
RUN chown -R www-data:www-data /var/www/html

# Install dependensi PHP
RUN composer install --no-dev --optimize-autoloader

# Generate key aplikasi jika belum ada
RUN php artisan key:generate --force

# Expose port
EXPOSE 8000

# Perintah untuk menjalankan aplikasi
CMD php artisan serve --host=0.0.0.0 --port=8000