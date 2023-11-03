FROM php:8.1-fpm-alpine
RUN apk --update --no-cache add postgresql-dev autoconf util-linux alpine-sdk bash tzdata nginx supervisor postgresql-client libxml2-dev libpng-dev libzip-dev zip p7zip
RUN apk add ldb-dev libldap wget make git ca-certificates gcc openldap-dev pcre-dev

RUN  git clone https://github.com/kvspb/nginx-auth-ldap.git /tmp/nginx-auth-ldap && \
     git clone https://github.com/nginx/nginx.git /tmp/nginx && \
      cd /tmp/nginx && \
    git checkout tags/release-1.22.0 && \
    ./auto/configure \
        --add-module=/tmp/nginx-auth-ldap \
        --with-http_ssl_module \
        --with-http_gzip_static_module \
        --with-pcre \
        --with-debug \
        --conf-path=/etc/nginx/nginx.conf \
        --sbin-path=/usr/sbin/nginx \
        --pid-path=/var/log/nginx/nginx.pid \
        --error-log-path=/var/log/nginx/error.log \
        --http-log-path=/var/log/nginx/access.log && \
    make install

RUN docker-php-ext-install pdo_pgsql pgsql intl
RUN docker-php-ext-install soap zip gd
RUN docker-php-ext-install ldap

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
  && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
  && php -r "unlink('composer-setup.php');"

COPY symfony.conf /etc/nginx/http.d/default.conf
COPY supervisord.conf /etc/supervisord.conf

WORKDIR /app

# Start supervisord and services
CMD /usr/bin/supervisord -n -c /etc/supervisord.conf
EXPOSE 8080
