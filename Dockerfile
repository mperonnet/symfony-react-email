FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy files
COPY . .

# Install dependencies
RUN composer install

# Install Node.js dependencies
RUN npm install

CMD ["php", "-a"]