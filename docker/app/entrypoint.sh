#!/bin/sh

FLAG_FILE="$APP_HOME/first_run_done"

if [ ! -f "$FLAG_FILE" ]; then
    echo "First run, running migrations and seeders..."

    MAX_RETRIES=5
    WAIT_TIME=5
    RETRY_COUNT=0

    until php artisan migrate --force; do
        RETRY_COUNT=$((RETRY_COUNT + 1))

        if [ "$RETRY_COUNT" -ge "$MAX_RETRIES" ]; then
        echo "Max retries reached. Migrations failed."
        exit 1
        fi

        echo "Migration failed. Retrying in $WAIT_TIME seconds... ($RETRY_COUNT/$MAX_RETRIES)"
        sleep $WAIT_TIME
    done

    php artisan db:seed --force

    touch "$FLAG_FILE"
    else
    echo "Application has already been initialized, skipping migrations and seeders."
    fi

# Run SSR server
php artisan inertia:start-ssr &

exec php-fpm
