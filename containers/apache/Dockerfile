FROM alpine:latest

COPY startup.sh /startup.sh

RUN mkdir -p /var/www/user-apps && chmod 755 /var/www/user-apps \
    && chmod 755 /startup.sh \
    && apk update \
    && apk add --no-cache \
    sudo tzdata apache2 apache2-http2 php8 php8-apache2 php8-pgsql php8-pear php8-phar php8-zip php8-json php8-common \
    php8-curl php8-exif php8-fileinfo php8-fpm php8-gd php8-iconv php8-gmp \
    php8-mbstring php8-openssl php8-pdo php8-pdo_pgsql php8-session \
    php8-xml php8-sockets php8-xmlreader php8-xmlwriter php8-xsl php8-tokenizer php8-dom \
    && ln -s /usr/bin/php8 /usr/bin/php \
    && sed -i 's/;date.timezone =/date.timezone ="Asia\/Tokyo"/g' /etc/php8/php.ini \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer \
    && sed -i '/LoadModule rewrite_module/s/^#//g' /etc/apache2/httpd.conf \
    && echo "IncludeOptional /etc/apache2/conf.d/vhosts/*.conf" >> /etc/apache2/httpd.conf \
    && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && echo "Asia/Tokyo" >  /etc/timezone \
    && apk del tzdata \
    && composer global require laravel/installer \
    && echo "apache ALL=NOPASSWD: ALL" >> /etc/sudoers

WORKDIR /var/www/vhostmanager

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

EXPOSE 80
CMD ["/startup.sh"]