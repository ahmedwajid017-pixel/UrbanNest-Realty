# UrbanNest Realty

UrbanNest Realty is a Laravel-based real estate management application designed to manage property listings, categories, agents, and property documents.

The application includes a property management interface with custom role-based access control (RBAC), allowing Owners, Agents, and Staff to access features according to their assigned permissions.

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

### 1. Property Management

- View property listings.
- Create new property records.
- View individual property details.
- Edit and update existing properties.
- Delete property records.

### 2. Multiple Image Uploads

- Upload multiple images for a single property.
- Support JPG, JPEG, PNG, and WEBP formats.
- Maximum 10 images per upload request.
- Maximum file size of 5 MB per image.
- Display uploaded images on the property details page.
- Upload additional images when updating a property.
- Store uploaded images using Laravel's public storage disk.

### 3. Role-Based Access Control (RBAC)

The application uses a custom role-based access control system with three roles:

| Role | Permissions |
|---|---|
| Owner | Full access to property management, including creating, viewing, updating, and deleting properties. |
| Agent | Can manage properties assigned to their agent account. |
| Staff | Can view property listings but cannot create, update, or delete properties. |

RBAC implementation includes:

- Custom roles table with Owner, Agent, and Staff roles.
- Role assignment through the `role_id` relationship on users.
- Custom `CheckRole` middleware to restrict protected routes.
- `PropertyPolicy` to control property-related actions.
- Agent ownership checks to prevent agents from modifying other agents' properties.
- Protected admin routes requiring authentication and an authorized role.

### 4. Authentication and Security

- User registration and login using Laravel Breeze.
- Password hashing.
- Authentication-protected routes.
- Role-based authorization.
- Property ownership validation.
- Server-side validation for uploaded images.
- Mass assignment protection through model fillable attributes.
- CSRF protection through Laravel's web middleware.
- XSS protection through Blade's default output escaping.

### 5. Other Features

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

The migrations create the required tables for users, roles, agents, categories, properties, documents, and property images.

### 6. Run Database Seeders

To insert sample data using the database seeders, run:

```bash
docker compose exec laravel.test php artisan db:seed
```

The seeders create:

- Default roles: Owner, Agent, and Staff.
- Demo users assigned to Owner, Agent, and Staff roles.
- Sample property categories.
- Sample real estate agents.
- Sample properties.
- Sample property documents.

To seed roles separately:

```bash
docker compose exec laravel.test php artisan db:seed --class=RoleSeeder
```

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

You must log in with an account that has an authorized role.

## User Roles and Account Assignment


Newly registered users are automatically assigned the Staff role.

For development purposes, the database seeder creates demo Owner, Agent, and Staff accounts. Additional roles can be assigned through an authorized administrative process.
For development purposes, roles can be assigned using Laravel Tinker:

```bash
docker compose exec laravel.test php artisan tinker
```

Example of assigning the Owner role:

```php
$user = App\Models\User::where('email', 'user@example.com')->firstOrFail();

$user->role_id = App\Models\Role::where('name', 'Owner')->firstOrFail()->id;

$user->save();
```

For Agent accounts, an existing Agent record must also be linked through the user's `agent_id` field.

## Running Migrations and Seeders Together

To reset the database, recreate all tables, and insert fresh sample data, run:

```bash
docker compose exec laravel.test php artisan migrate:fresh --seed
```

**Note:** This command deletes all existing database records before recreating the tables and running the seeders. Use it only when you intend to reset the database.

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

## Security and Authorization

The application uses Laravel middleware and policies to protect property management operations.

- Authentication middleware ensures users are logged in.
- Role middleware checks whether users have an authorized role.
- Property policies enforce permissions for individual property actions.
- Agents can only manage properties assigned to their agent accounts.
- Staff users have view-only access to property listings.
- Owner users have full property management permissions.

### Security Check Command

The project includes a custom Artisan command to check important security configurations.

Run:

```bash
docker compose exec laravel.test php artisan security:check
```

The command checks:

- Role middleware registration.
- Property policy registration.
- Existence of Owner, Agent, and Staff roles.
- Public storage link.

### Security Review

The SECURITY_REVIEW.md file contains the project's security review, covering authentication, authorization, input validation, mass assignment, XSS protection, file uploads, and CSRF protection.

## Running Tests

Run the Laravel test suite using:

```bash
docker compose exec laravel.test php artisan test
```

## Project Structure

Important project directories:

```text
app/
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       └── PropertyController.php
│   ├── Middleware/
│   │   └── CheckRole.php
│   └── Requests/
│       └── StorePropertyRequest.php
├── Models/
│   ├── User.php
│   ├── Role.php
│   ├── Agent.php
│   ├── Category.php
│   ├── Document.php
│   └── Property.php
└── Policies/
    └── PropertyPolicy.php

database/
├── migrations/
├── factories/
└── seeders/

resources/
└── views/

routes/
├── web.php
└── auth.php

SECURITY_REVIEW.md
README.md
```

## Author

**Wajid Ahmed**

GitHub: https://github.com/ahmedwajid017-pixel

## Project Repository

[UrbanNest Realty – GitHub Repository](https://github.com/ahmedwajid017-pixel/UrbanNest-Realty)