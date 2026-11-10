# UrbanNest Realty

UrbanNest Realty is a Laravel-based real estate management application designed to manage property listings, categories, agents, and property documents.

The application includes a staff property management interface that allows users to create, view, update, and delete properties, along with uploading and displaying multiple images for each property.

## Technologies Used

- PHP
- Laravel
- MySQL
- Blade Templates
- Bootstrap 5
- Bootstrap Icons
- Docker
- Git and GitHub

## Features

### Property Management

- View all property listings.
- Create new property records.
- View individual property details.
- Edit and update existing properties.
- Delete property records.

### Multiple Image Uploads

- Upload multiple images against a single property.
- Support for JPG, JPEG, PNG, and WEBP formats.
- Maximum 10 images per upload request.
- Maximum file size of 5 MB per image.
- Display uploaded images on the property details page.
- Upload additional images when updating a property.
- Store uploaded images using Laravel's public storage disk.

### Other Features

- Manage property categories.
- Manage real estate agents.
- Store property-related documents.
- Maintain relationships between properties, categories, agents, and images.

## Project Setup

### Requirements

Make sure you have installed:

- Docker Desktop
- Git
- Visual Studio Code

### 1. Clone the Repository

```bash
git clone https://github.com/ahmedwajid017-pixel/UrbanNest-Realty.git
```

Navigate to the project directory:

```bash
cd UrbanNest-Realty
```

### 2. Configure Environment

Copy the example environment file:

```bash
cp .env.example .env
```

Make sure your database configuration in `.env` matches the MySQL service configured in `compose.yaml`.

### 3. Start Docker Containers

Make sure Docker Desktop is running, then execute:

```bash
docker compose up -d
```

### 4. Generate Application Key

```bash
docker compose exec laravel.test php artisan key:generate
```

### 5. Run Database Migrations

To create all database tables using the migration files, run:

```bash
docker compose exec laravel.test php artisan migrate
```

This creates the required tables for:

- Users
- Categories
- Agents
- Properties
- Documents
- Property Images

### 6. Run Database Seeders

To insert sample data using factories and `DatabaseSeeder.php`, run:

```bash
docker compose exec laravel.test php artisan db:seed
```

The seeders create sample data, including:

- 5 categories
- 5 agents
- 20 properties
- 30 documents

### 7. Configure Public Image Storage

Create the symbolic link for accessing uploaded images:

```bash
docker compose exec laravel.test php artisan storage:link
```

Uploaded property images are stored in:

```text
storage/app/public/properties
```

The public storage link is available through:

```text
public/storage
```

### 8. Access the Application

Open the application in your browser:

```text
http://localhost
```

To access the property management interface:

```text
http://localhost/admin/properties
```

## Running Migrations and Seeders Together

To reset the database, recreate all tables, and insert fresh sample data, run:

```bash
docker compose exec laravel.test php artisan migrate:fresh --seed
```

**Note:** This command deletes all existing database records before recreating the tables and running the seeders.

## Property Image Validation

The application validates uploaded images using Laravel validation rules.

Supported formats:

- JPG
- JPEG
- PNG
- WEBP

Upload restrictions:

- Maximum 10 images per upload request.
- Maximum 5 MB per image.
- Non-image files are rejected.

## Project Structure

Important project directories:

```text
app/
 ├── Http/
 │    ├── Controllers/
 │    │    └── Admin/
 │    │         └── PropertyController.php
 │    └── Requests/
 │         └── StorePropertyRequest.php
 │
 └── Models/
      ├── Agent.php
      ├── Category.php
      ├── Document.php
      ├── Property.php
      └── PropertyImage.php

database/
 ├── migrations/
 ├── factories/
 └── seeders/

resources/
 └── views/
      ├── layouts/
      └── admin/
           └── properties/
                ├── index.blade.php
                ├── create.blade.php
                ├── edit.blade.php
                └── show.blade.php
```

## Author

**Wajid Ahmed**

GitHub: [ahmedwajid017-pixel](https://github.com/ahmedwajid017-pixel)

## Project Repository

[UrbanNest Realty – GitHub Repository](https://github.com/ahmedwajid017-pixel/UrbanNest-Realty)