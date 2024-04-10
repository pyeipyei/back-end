# Use the official PHP image as the base image
FROM php:8.1.25-fpm-alpine3.16

# set timezone arg
ARG TZ=Asia/Tokyo

## allow root install for composer
ENV COMPOSER_ALLOW_SUPERUSER 1 \
  COMPOSER_NO_INTERACTION 1 \
# when you set composer work directory, please edit this env parameter.
  COMPOSER_HOME /var/www

# import laravel project source code
COPY . /var/www
RUN chmod -R 777 /var/www

# Set working directory
WORKDIR /var/www

# install php module setup
RUN set -eux && \
  apk upgrade && \
# add build dependencies
  apk add --update linux-headers && \
  apk add --update --no-cache --virtual=.build-dependencies \
    autoconf \
    gcc \
    g++ \
    make \
    tzdata && \
  apk add --no-cache --update \
    icu-dev \
    libzip-dev && \
# set time zone
  cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
  echo ${TZ} > /etc/timezone && \
  apk del .build-dependencies && \
# install php module
  docker-php-ext-install intl pdo_mysql zip bcmath


# install composer ver2 (multi stage build)
# COPY --from=composer:2.2.6 /usr/bin/composer /usr/bin/composer
RUN apk add mysql-client
RUN apk add --update linux-headers
# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install
# ADD zz-docker.conf /usr/local/etc/php-fpm.d
ADD entrypoint.sh /tmp
RUN chmod +x /tmp/entrypoint.sh
ENTRYPOINT ["/tmp/entrypoint.sh"]
