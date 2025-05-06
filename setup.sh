#!/bin/bash
# Crear proyecto Laravel en directorio temporal
docker compose run --rm app composer create-project laravel/laravel /var/www/temp
# Mover archivos desde el directorio temporal
docker compose run --rm app sh -c "mv /var/www/temp/* /var/www/ && mv /var/www/temp/.* /var/www/ 2>/dev/null || true"
# Limpiar directorio temporal
docker compose run --rm app rm -rf /var/www/temp`