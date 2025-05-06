FROM php:8.3-fpm
# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Establecer directorio de trabajo
WORKDIR /var/www/src
# Copiar archivos de la aplicación
# COPY . /var/www
# Instalar dependencias
# RUN composer install
# Permisos para el usuario www-data
# RUN chown -R www-data /var/www
# RUN chmod -R 755 /var/www/storage
EXPOSE 9000
CMD ["php-fpm"]