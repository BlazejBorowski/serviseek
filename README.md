# ServiSeek

## Version

v.0.0.1

## Description

ServiSeek is a web platform designed to connect clients with local service providers, freelancers, and manufacturers. It facilitates the search, booking, and review of services, providing a comprehensive platform for managing customer and service provider interactions. ServiSeek makes it easy for users to find professionals in their area, enhance engagement through interactive reviews, and build a community of trusted professionals.

## Requirements

-   **PHP**: 8.3 or higher
-   **Node**: 18.13.0 or higher

## Main Technologies used

-   **Laravel**: v11
-   **Inertia**: v1 (will be changed to v2)
-   **React**: v18

## Additional Technologies used

-   **TypeScript**
-   **MySQL**
-   **SQLite**
-   **Docker**
-   **ELK Stack**
-   **Laravel Pennant**
-   **Redis**
-   **PHPUnit**
-   **Infection**
-   **Jest**
-   **Cypress**
-   **Laravel Pint**
-   **Larastan**
-   **ESLint**
-   **Storybook**
-   **Mailpit**
-   **LocalStack**
-   **Nginx**

## License

ServiSeek is open-sourced under the MIT license, which permits free use, modification, and distribution of the software.

## Start help

There are three ways to setup project:

1. Local
    1. Copy .env.local to .env
    2. composer install
    3. npm install
    4. php artisan key:generate
    5. php artisan migrate --seed
    6. Run composer run dev
2. Local with Services
    1. Copy .env.local-with-services.local to .env
    2. ...
    3. Run composer run dev
3. Docker with Services
    1. Run docker-compose --env-file .env.docker up -d
    2. ...
    3. Setup Kibana ... elasticsearch-create-enrollment-token -s kibana
