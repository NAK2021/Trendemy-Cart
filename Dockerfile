FROM php:8.2.0

# Cài đặt các phụ thuộc
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    zlib1g-dev \
    libxml2-dev \
    libzip-dev \
    libonig-dev \
    graphviz \
    && docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql mysqli zip sockets \
    && docker-php-source delete

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Thiết lập thư mục làm việc
WORKDIR /app
COPY . .

# Cài đặt các thư viện PHP qua Composer
RUN composer install


# Khởi động ứng dụng Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT}

