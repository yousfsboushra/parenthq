FROM php:7.4-apache
# RUN apt-get update && apt-get install -y \
#         libfreetype6-dev \
#         libjpeg62-turbo-dev \
#         libpng-dev \
#         libpq-dev \
#     && docker-php-ext-install -j$(nproc) iconv \
#     && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#     && docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-install -j$(nproc) pdo \
#     && docker-php-ext-install -j$(nproc) pdo_mysql \
#     && docker-php-ext-install -j$(nproc) zip

RUN a2enmod rewrite
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN echo "Listen 8080" >> /etc/apache2/ports.conf
RUN service apache2 restart

WORKDIR /var/www
COPY  ./ /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN composer install
RUN chown -R www-data:www-data /var/www/
EXPOSE 8080