FROM php:8.2-apache


RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs


RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html


COPY composer.json composer.lock package*.json ./


RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts


RUN npm ci


COPY . /var/www/html


RUN composer run-script post-autoload-dump --no-interaction || true

RUN npm run build

# 🧹 OPCIONAL: Limpia node_modules después del build para reducir tamaño de imagen
RUN rm -rf node_modules && npm ci --omit=dev

# Verificación de build
RUN echo "======================================" && \
    echo "📦 VERIFICACIÓN DE BUILD" && \
    echo "======================================" && \
    ls -lah public/ && \
    echo "" && \
    echo "📁 Contenido de public/build:" && \
    ls -lah public/build/ && \
    echo "" && \
    if [ -f "public/build/manifest.json" ]; then \
        echo "✅ manifest.json encontrado:"; \
        cat public/build/manifest.json; \
    else \
        echo "❌ manifest.json NO encontrado!"; \
        exit 1; \
    fi && \
    echo "" && \
    echo "🎨 Archivos CSS:" && \
    find public/build -name "*.css" -exec ls -lh {} \; && \
    echo "" && \
    echo "⚡ Archivos JS:" && \
    find public/build -name "*.js" -exec ls -lh {} \; && \
    echo "======================================"

# Configura permisos
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache \
    /var/www/html/public && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 755 /var/www/html/public

# Habilita módulos de Apache
RUN a2enmod rewrite headers expires deflate

# Copia configuración de Apache
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf


# Copia y configura entrypoint
COPY docker/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]