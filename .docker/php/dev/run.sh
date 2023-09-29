#!/bin/sh

# install application
composer install --no-interaction
sleep 5
composer migrate --no-interaction

# run supervisord
/usr/bin/supervisord -c /etc/supervisord.conf

# php-fpm
php-fpm
