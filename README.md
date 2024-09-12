# Product Management Task

**product-management-task** is a full-stack application for managing products, customers, and orders, with authentication access control. The backend is built using the PHP Laravel framework, and the frontend uses Vue.js with Pinia for state management and Vue Router for routing.
For this task, utilized job queues to handle CSV file imports for orders and product management efficiently. This approach ensures that large files are processed asynchronously, improving performance and user experience. For managing customer data, implemented traditional chunk operations to process data in manageable segments, which helps to reduce memory usage.

On the frontend, employed Vue.js for the user interface, using Pinia for state management. API calls are handled with axios, ensuring smooth communication between the client and server.

Successfully integrated product data retrieval from a Laravel API with Grav CMS, facilitating dynamic content management and presentation.

## Installation

Follow these steps to install and run the project locally with docker.

1. Clone the repository:

   ```bash
   git clone https://github.com/Shaon99/metricalo-product-management.git
   ```

### Backend Installation

Navigate to the backend directory:

```bash
    cd metricalo-product-management
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
```

For Product,Order Import Csv Need To Run php artisan queue:work

```bash
      docker-compose exec app bash
      php artisan queue:work
```

Product Csv Header: Name,Price,Description,Image
Customer Csv Header: first_name,last_name,email,phone,address
Order Csv Header: order_id,customer_id,total_amount,status,product_id,quantity,price

For Sanctum----->
APP_URL=http://localhost:8000
FRONTEND_URL=http://localhost:3000
SESSION_DOMAIN=localhost
SANCTUM_STATEFUL_DOMAINS=localhost:3000
--------------------->>>
The backend application should now be running at http://localhost:8000/.

phpMyAdmin can be accessed at http://localhost:8090/.

### Frontend Installation

Navigate to the frontend directory:

```bash
    cd metricalo-product-management
    cd frontend
```

Build and start the Docker containers:

```bash
    docker-compose up -d --build
```

The frontend application should now be running at http://localhost:3000/.


### Frontend GRAV CMS Installation

Navigate to the grav directory:

```bash
    cd metricalo-product-management
    cd grav
```

Build and start the Docker containers:

```bash
    docker-compose up -d --build
```
create a backup directory on grav/grav directory

The Grav Cms frontend application should now be running at http://localhost:8080/. (you can change port on compose.yml file if any mismatch)


For any inquiries or issues, please contact:

Name: Shaon Ahmed
Email: shaonahmed703@gmail.com
