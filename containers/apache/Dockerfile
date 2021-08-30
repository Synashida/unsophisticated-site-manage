FROM alpine:latest

COPY startup.sh /startup.sh

RUN mkdir -p /var/www/user-apps && chmod 755 /var/www/user-apps \
    && chmod 755 /startup.sh \
    && apk update \
    && apk add --no-cache \
    sudo tzdata apache2 apache2-http2 mysql-client php php-apache2 php-pgsql php7-mysqli php-pdo_mysql php-pear php-phar php-zip php-json php-common \
    php-curl php-exif php-fileinfo php-fpm php-gd php-iconv php-gmp \
    php-mbstring php-openssl php-pdo php-pdo_pgsql php-session \
    php-xml php-sockets php-xmlreader php-xmlwriter php-xsl php-tokenizer php-dom \
    && sed -i 's/;date.timezone =/date.timezone = "Asia\/Tokyo"/g' /etc/php7/php.ini \
    && sed -i 's/;error_log = syslog/error_log = \/var\/www\/vhostmanager\/storage\/logs\/php_error_log.log/g' /etc/php7/php.ini \
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
    && echo "apache ALL=NOPASSWD: ALL" >> /etc/sudoers \
    && apk add --no-cache curl \
    && cd tmp && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar && mv wp-cli.phar /usr/bin/wp
    

#RUN mkdir -p /var/www/user-apps && chmod 755 /var/www/user-apps \
#    && chmod 755 /startup.sh \
#    && apk update \
#    && apk add --no-cache \
#    sudo tzdata apache2 apache2-http2 php php-apache2 php-pgsql php-pear php-phar php-zip php-json php-common \
#    php-curl php-exif php-fileinfo php-fpm php-gd php-iconv php-gmp \
#    php-mbstring php-openssl php-pdo php-pdo_pgsql php-session \
#    php-xml php-sockets php-xmlreader php-xmlwriter php-xsl php-tokenizer php-dom \
#    && ln -s /usr/bin/php /usr/bin/php \
#    && sed -i 's/;date.timezone =/date.timezone ="Asia\/Tokyo"/g' /etc/php/php.ini \
#    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
#    && php composer-setup.php \
#    && php -r "unlink('composer-setup.php');" \
#    && mv composer.phar /usr/bin/composer \
#    && sed -i '/LoadModule rewrite_module/s/^#//g' /etc/apache2/httpd.conf \
#    && echo "IncludeOptional /etc/apache2/conf.d/vhosts/*.conf" >> /etc/apache2/httpd.conf \
#    && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
#    && echo "Asia/Tokyo" >  /etc/timezone \
#    && apk del tzdata \
#    && composer global require laravel/installer \
#    && echo "apache ALL=NOPASSWD: ALL" >> /etc/sudoers

WORKDIR /var/www/vhostmanager

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

EXPOSE 80
CMD ["/startup.sh"]