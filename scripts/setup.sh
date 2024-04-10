#!/usr/bin/env bash

# project list
projects=(
    "api-gateway"
    "customers-japan"
    "employees"
    "employees-japan"
)

# database names
databases=(
    "api_gateway"
    "customers_japan"
    "employees"
    "employees_japan"
)

# migrate database for each project with database name
for i in "${!projects[@]}"; do
    cd "${projects[$i]}"
    composer install
    echo "Migrating database for ${projects[$i]}..."
    php artisan migrate --database="${databases[$i]}"
    # shellcheck disable=SC2103
    cd ..
done