#!/usr/bin/env bash


cd api-gateway
php artisan serve --port 8000 &

cd ../employees
php artisan serve --port 8001 &

cd ../employees-japan
php artisan serve --port 8002 &

cd ../customers-japan
php artisan serve --port 8003 &