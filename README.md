# Metricalo Product Management Task

**Metricalo-product-management-task** is a full-stack application for managing products, customers, and orders, with authentication access control. The backend is built using the PHP Laravel framework, and the frontend uses Vue.js with Pinia for state management and Vue Router for routing.

## Installation

Follow these steps to install and run the project locally with docker.

1. Clone the repository:

   ```bash
   git clone https://github.com/Shaon99/Metricalo-product-management.git
   ```

### Backend Installation

Navigate to the backend directory:
```bash
    cd Metricalo-product-management
    cd backend
```

Build and start the Docker containers:

```bash
    docker-compose up -d --build
```

Copy the environment file:

```bash
    cp .env.example .env
```

Install the dependencies

```bash
    docker-compose exec app composer update
```

Generate the application key, Migration, Optimization cache clear:

```bash
    docker-compose exec app bash
      php artisan key:generate
      php artisan optimize:clear
      php artisan migrate
      ||
      docker-compose exec app
      php artisan key:generate
      php artisan optimize:clear
      php artisan migrate
```
For Sanctum----->
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:3000
--------------------->>>
The backend application should now be running at http://localhost:8000/.

phpMyAdmin can be accessed at http://localhost:8080/.

### Frontend Installation

Navigate to the frontend directory:

```bash
    cd Metricalo-product-management
    cd frontend
```

Build and start the Docker containers:

```bash
    docker-compose up -d --build
```

The frontend application should now be running at http://localhost:3000/.


For any inquiries or issues, please contact:

Name: Shaon Ahmed
Email: shaonahmed703@gmail.com
