# MobilityTodo - Project Setup Instructions

## 1. Clone the Repository

To begin, clone the repository into your project directory:

```bash
git clone git@github.com:YZinych/MobilityTodo.git .
```

## 2. Configure Environment Variables

Copy the environment variable files

```bash
# Copy environment variables for Laravel
cp .env.example .env

# Copy environment variables for Docker
cp docker-db.env.example docker-db.env
```

### Optional:
Update the database credentials in `.env` and `docker-db.env` files to match your database setup

## 3. Build the Docker Images

Build the Docker images for the application without using the cache:

```bash
docker-compose build --no-cache
```

## 4. Start the Services

Start the application and database services in detached mode:

```bash
docker-compose up -d
```

## 5. Install Laravel Dependencies

Once the services are up, install Laravel's dependencies:

```bash
composer install
```

## 6. Generate Laravel Application Key

Generate the Laravel application key to secure your application:

```bash
php artisan key:generate
```

## 7. Run Database Migrations

Enter the app container and run the migrations to set up the database schema:

```bash
docker exec -it todo_laravel_app bash
php artisan migrate
```

## 8. Check the Database

- Make sure port `7761` is available on your machine.
- To ensure the database is properly configured, access the database check page using your `.env` credentials:

```text
http://localhost:7761/index.php
```

## 9. Access the Web Application

- Make sure port `8080` is available on your machine.
- Finally, access the Laravel application in your browser:

```text
http://localhost:8080/
```

---

