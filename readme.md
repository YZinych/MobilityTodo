# MobilityTodo - Project Setup Instructions

## 1. Clone the Repository

To begin, clone the repository into your project directory:

```bash
git clone git@github.com:YZinych/MobilityTodo.git .
```

## 2. Configure Environment Variables

Copy environment variables for Laravel

```bash
cp .env.example .env
```

Copy environment variables for Docker

```bash
cp docker-db.env.example docker-db.env
```

### Optional:
Update database settings in `.env` and `docker-db.env` files to prevent using demo credentials

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

## 5. Enter the app container

```bash
docker exec -it todo_laravel_app bash
```

## 6. Install Laravel Dependencies

Install Laravel's dependencies:

```bash
composer install
```

## 7. Generate Laravel Application Key

Generate the Laravel application key to secure your application:

```bash
php artisan key:generate
```

## 8. Run Database Migrations

```bash
php artisan migrate
```

## 9. Install Node modules and prepare Assets

```bash
npm install
```

```bash
npm run dev
```

## 10. Check the Database

- Make sure port `7761` is available on your machine.
- To ensure the database is properly configured, access the database check page using your `.env` credentials:

```text
http://localhost:7761/index.php
```

## 11. Access the Web Application

- Make sure port `8080` is available on your machine.
- Finally, access the Laravel application in your browser:

```text
http://localhost:8080/
```

---

