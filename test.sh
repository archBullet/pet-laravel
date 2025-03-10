#!/bin/bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan clear
php artisan migrate:fresh --env=testing
php artisan test $*
