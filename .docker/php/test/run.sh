#!/bin/sh

# install application
composer install --no-interaction

# run supervisord
/usr/bin/supervisord -c /etc/supervisord.conf

php-fpm
