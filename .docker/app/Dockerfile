FROM php:8.2-fpm-alpine

RUN apk update && \
    apk upgrade && \
    apk add --update \
    alpine-sdk \
    sed \
    util-linux \
    tzdata \
    mysql-client \
    autoconf \
    gmp-dev \
    rabbitmq-c \
    rabbitmq-c-dev \
    libxml2-dev \
    libzip-dev \
    icu-dev \
    libxslt-dev \
    $PHPIZE_DEPS \
    linux-headers \
    libc6-compat && \
    rm -rf /var/cache/apk/*

#RUN  git clone https://github.com/kvspb/nginx-auth-ldap.git /tmp/nginx-auth-ldap && \
#     git clone https://github.com/nginx/nginx.git /tmp/nginx && \
#      cd /tmp/nginx && \
#    git checkout tags/release-1.22.0 && \
#    ./auto/configure \
#        --add-module=/tmp/nginx-auth-ldap \
#        --with-http_ssl_module \
#        --with-http_gzip_static_module \
#        --with-pcre \
#        --with-debug \
#        --conf-path=/etc/nginx/nginx.conf \
#        --sbin-path=/usr/sbin/nginx \
#        --pid-path=/var/log/nginx/nginx.pid \
#        --error-log-path=/var/log/nginx/error.log \
#        --http-log-path=/var/log/nginx/access.log && \
#    make install

RUN pecl update-channels && \
    pecl install amqp apcu uopz xdebug && \
    docker-php-ext-install zip intl  && \
    docker-php-ext-enable amqp apcu intl uopz xdebug && \
    docker-php-source delete && \
    rm -rf /tmp/pear ~/.pearrc && \
    rm -rf /var/cache/apk/*


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && php -r "unlink('composer-setup.php');"

COPY laravel.conf /etc/nginx/http.d/default.conf

WORKDIR /app

EXPOSE 8080
