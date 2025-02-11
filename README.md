# Trade Fair Exhibitors

A Laravel 11 project for managing trade fair exhibitors. This project includes MySQL database integration and a frontend using jQuery and Bootstrap 5.3.0.

## Getting Started

### 1️⃣ Prerequisites

Ensure you have the following installed:

-   **[Laragon](https://laragon.org/)** (for easy local development)
-   **[TablePlus](https://tableplus.com/)** (for database management)
-   **PHP 8.2+**
-   **Composer**
-   **Node.js & npm**

### 2️⃣ Clone the Repository

```sh
 git clone https://github.com/Im-Just-Ken/trade-fair-exhibitors.git
 cd trade-fair-exhibitors
```

### 3️⃣ Configure Environment Variables

1. Copy the `.env.example` file and rename it to `.env`.
2. Update the database credentials in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=trade_fair
DB_USERNAME=root
DB_PASSWORD=
```

### 4️⃣ Install Dependencies

```sh
composer install
npm install
```

### 5️⃣ Set Up the Database

#### Using **TablePlus**:

1. Open **TablePlus** and create a new connection for MySQL.
2. Set the database name to `trade_fair`.
3. Click `Connect`.

#### Using **MySQL CLI**:

```sh
mysql -u root -p -e "CREATE DATABASE trade_fair;"
```

### 6️⃣ Run Migrations & Seeders

```sh
php artisan migrate --seed
```

### 7️⃣ Run the Application

```sh
php artisan serve
```

Your Laravel app will now be running at: `http://127.0.0.1:8000`

### 8️⃣ Run Vite for Frontend

```sh
npm run dev
```

## API Endpoints

| Method | Endpoint                          | Description               |
| ------ | --------------------------------- | ------------------------- |
| GET    | `/api/exhibitors`                 | Fetch all exhibitors      |
| GET    | `/api/exhibitors/{id}`            | Get a specific exhibitor  |
| GET    | `/api/exhibitors/search?name=xyz` | Search exhibitors by name |
| POST   | `/api/exhibitors`                 | Add a new exhibitor       |
| PATCH  | `/api/exhibitors/{id}`            | Update an exhibitor       |
| DELETE | `/api/exhibitors/{id}`            | Delete an exhibitor       |

## Notes

-   The database is configured to run locally via **Laragon**.
-   Make sure MySQL is running before running migrations.
-   If using a different database system, update `.env` accordingly.
