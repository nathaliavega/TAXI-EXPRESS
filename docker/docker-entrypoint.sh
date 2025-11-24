#!/bin/bash
set -e

echo "==================================="
echo "Iniciando aplicación Laravel..."
echo "==================================="

PORT=${PORT:-10000}
echo "Puerto configurado: $PORT"

sed -i "s/Listen \${PORT}/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
sed -i "s/\:\${PORT}/:$PORT/g" /etc/apache2/sites-available/000-default.conf

echo "Esperando por la base de datos..."
sleep 5

echo "==================================="
echo "🔄 Ejecutando migraciones (incluye encriptación)..."
echo "==================================="
php artisan migrate --force

echo "Optimizando aplicación..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Verificando permisos..."
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "==================================="
echo "✅ Aplicación lista!"
echo "👤 Usuario admin: elder.garcia@gmail.com"
echo "🔑 Contraseña: elder123"
echo "==================================="
echo "Iniciando Apache en puerto $PORT..."
echo "==================================="

apache2-foreground