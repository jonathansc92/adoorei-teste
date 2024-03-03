#!/bin/bash

cd /var/www/html
composer install
chmod -R 777 storage/

cp /var/www/html/.env.example /var/www/html/.env
php artisan key:generate
php artisan migrate --seed

chmod -R 777 /var/www/html/storage/

apache2-foreground