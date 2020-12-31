FROM php:7.4.8-apache

LABEL command.composer=yes command.php=yes

ARG DEBIAN_FRONTEND=noninteractive
ARG USER_HOME

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV TZ=America/Manaus

ENV COMPOSER_HOME=${USER_HOME}/.composer

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt update && apt install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure exif --enable-exif \
    && docker-php-ext-install -j$(nproc) exif \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-install -j$(nproc) mysqli \
    && docker-php-ext-configure bcmath --enable-bcmath

#RUN pecl install xdebug \
#&& docker-php-ext-enable xdebug \ 
#&& echo "xdebug.remote_enable=on" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.remote_handler=dbgp" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.remote_port=9000" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.client_port=9003" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.remote_autostart=on" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.mode=debug" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.start_with_request=yes" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.remote_connect_back=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.discover_client_host=1" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.idekey=docker" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.remote_log=/tmp/xdebug.log" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.log=/tmp/xdebug.log" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini \
#&& echo "xdebug.max_nesting_level=1500" >> $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN a2enmod rewrite

RUN sed -ri -e 's!memory_limit = 128M!memory_limit = 300M!g' $PHP_INI_DIR/php.ini


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r '$checksum = file_get_contents("https://composer.github.io/installer.sig"); \
if (hash_file("sha384", "composer-setup.php") === $checksum) { echo "Installer verified"; } else { echo "Installer corrupt"; unlink("composer-setup.php"); } echo PHP_EOL;' \
&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
&& php -r "unlink('composer-setup.php');"

