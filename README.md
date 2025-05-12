# 🚀 Laravel 12 Patient API (PostgreSQL + PHP 8.3 + Docker)

This is a backend REST API built with **Laravel 12**, **PHP 8.3**, and **PostgreSQL**, designed to manage patient records securely. It uses Docker for easy local development and follows clean code architecture with service layer and custom middleware.

---

## 📦 Tech Stack

- **Laravel 12**
- **PHP 8.3**
- **PostgreSQL** (hosted locally)
- **Docker** (for PHP & NGINX)
- **Custom Middleware** (accessKey authentication)
- **Service Layer Pattern**

---

## 🛠 Features

- ✅ Full CRUD API for Patients
- ✅ Each patient is linked to a User record
- ✅ Custom fields for Users (id_type, id_no, gender, dob, address)
- ✅ Secured using an `accessKey` header
- ✅ Dockerized PHP/Nginx setup (database runs locally)
- ✅ Clean MVC structure + Service logic separation

---

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/PatientController.php
│   ├── Models/Patient.php
│   ├── Services/PatientService.php
│   └── Middleware/CheckAccessKey.php
├── bootstrap/
│   └── app.php (middleware registered here)
├── database/
│   ├── migrations/
│   └── seeders/
├── docker/
│   └── nginx/default.conf
├── docker-compose.yml
├── Dockerfile
└── .dockerignore
```

---

## 🚀 Getting Started

### 1. Clone the repo

```bash
git clone https://your-repo-url.git
cd your-repo-folder
```

---

### 2. Copy `.env` and configure database

```bash
cp .env.example .env
```

Update the DB settings to use your **local PostgreSQL**:

```env
DB_CONNECTION=pgsql
DB_HOST=host.docker.internal
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
ACCESS_KEY=supersecret123
```

---

### 3. Start Docker and build the container

```bash
docker-compose up -d --build
```

---

### 4. Install dependencies and migrate the database

```bash
docker-compose exec app composer install
docker-compose exec app php artisan migrate
```

---

## 🔐 Security via Access Key

All endpoints are protected by an `accessKey` header.

Include this in every request:

```http
accessKey: supersecret123
```

Unauthorized requests will return `401 Unauthorized`.

---

## 📡 API Endpoints

| Method | Endpoint             | Description               |
|--------|----------------------|---------------------------|
| GET    | /api/v1/patients     | List all patients         |
| GET    | /api/v1/patients/{id}| Get single patient detail |
| POST   | /api/v1/patients     | Create new patient        |
| PUT    | /api/v1/patients/{id}| Update patient            |
| DELETE | /api/v1/patients/{id}| Delete patient & user     |

---

## 🔧 Example Request Payload (POST & PUT)

```json
{
  "name": "John Doe",
  "email": "john.doe@example.com",
  "password": "StrongPass123",
  "id_type": "KTP",
  "id_no": "1234567890123456",
  "gender": "male",
  "dob": "1990-05-12",
  "address": "123 Example Street, Jakarta, Indonesia",
  "medium_acquisition": "Online Campaign"
}
```

---

## 📌 Notes

- PostgreSQL must be installed and running locally
- The API will be served at `http://localhost:8080`
- Default Laravel port for PHP-FPM is 9000
- You can export and try the API using Postman

---

## 🧑‍💻 Author

Built with ❤️ using Laravel 12 + PostgreSQL
