# BeaRebaja Student Management

A single-page Laravel application for creating, viewing, editing, and deleting student records.

## Local development

Requirements: PHP 8.3+, Composer, Node.js, and npm.

```sh
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```

Open `http://localhost:8000`. The application uses the database connection configured in `.env`.

Run the focused feature tests with:

```sh
php artisan test --compact tests/Feature/StudentManagementTest.php
```

## Deploy to Render

This repository includes a `render.yaml` Blueprint and Dockerfile. In Render, create a new Blueprint instance and connect the GitHub repository. Render builds the Docker image, generates `APP_KEY`, runs pending migrations at startup, and checks the `/up` health endpoint. Pushes to the configured branch trigger automatic deployments.

The included free demo configuration uses SQLite on Render's ephemeral filesystem. **Student records can be lost when the service restarts, sleeps, or redeploys. Do not use this setup for important or production data.** For durable production data, use a persistent database such as Render PostgreSQL and configure the service's `DB_CONNECTION` and database URL accordingly; a persistent database may incur charges.
