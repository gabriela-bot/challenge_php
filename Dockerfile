FROM php:8.2-fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev\
    libwebp-dev \
    libfreetype6-dev\
    libjpeg62-turbo-dev \
    libcurl4-openssl-dev\
    zip \
    unzip \
    vim \
    nodejs \
    npm \
    dos2unix

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp
RUN docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        xml \
        curl\
	    intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

COPY php.ini /etc/php/8.2/fpm/php.ini
COPY laravel_start /usr/local/bin/laravel_start
RUN dos2unix /usr/local/bin/laravel_start
RUN chmod +x /usr/local/bin/laravel_start

USER $user

WORKDIR /var/www

COPY . /var/www

EXPOSE 9000

ENTRYPOINT ["laravel_start"]

