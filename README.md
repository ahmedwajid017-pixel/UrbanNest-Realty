## Running Migrations and Seeders

Make sure Docker Desktop is running and start the Laravel application:

```bash
docker compose up -d
```

### 1. Run Database Migrations

To create the database tables using the migration files, run:

```bash
docker compose exec laravel.test php artisan migrate
```

This command creates the required tables for categories, agents, properties, and documents.

### 2. Run Database Seeders

To insert sample data into the database using the factories and `DatabaseSeeder.php`, run:

```bash
docker compose exec laravel.test php artisan db:seed
```

The seeder creates:
- 5 categories
- 5 agents
- 20 properties
- 30 documents

### 3. Reset Database and Run Seeders

To drop all existing tables, run migrations again, and insert fresh sample data, use:

```bash
docker compose exec laravel.test php artisan migrate:fresh --seed
```

**Note:** This command deletes existing database records before recreating the tables and seeding sample data.