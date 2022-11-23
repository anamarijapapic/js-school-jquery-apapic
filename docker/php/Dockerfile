FROM php:8.0.19-fpm-buster

# Copy php-extension-installer script for easy installation of PHP extensions
# https://github.com/mlocati/docker-php-extension-installer#supported-php-extensions

COPY --from=mlocati/php-extension-installer:1.5.11 /usr/bin/install-php-extensions /usr/local/bin/

# install the PHP extensions we need

RUN install-php-extensions zip gd mysqli xdebug opcache

# copy certificate authority

COPY ./certificate-authority/certificate.cert /usr/local/share/ca-certificates/certificate.crt
RUN update-ca-certificates

# add config overrides

COPY zz-php.ini $PHP_INI_DIR/conf.d/zz-php.ini
COPY zz-www.conf /usr/local/etc/php-fpm.d/zz-www.conf
COPY zz-xdebug.ini $PHP_INI_DIR/conf.d/zz-xdebug.ini
COPY zz-opcache.ini $PHP_INI_DIR/conf.d/zz-opcache.ini
