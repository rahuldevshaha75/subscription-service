# Subscription Management Service

A standalone **Laravel-based Subscription Management Microservice**. This service manages user subscriptions, packages, trial logic, and subscription history. User authentication is assumed to be handled by an external service, and this service only consumes `user_id`.

---

## 🧰 Tech Stack

* PHP 8.x
* Laravel 12
* MySQL
* Docker & Docker Compose
* Postman (for API testing)

---

## 🚀 Project Setup (Run on Any Device)

### 1️⃣ Clone the Repository

```bash
git clone <your-repo-url>
cd subscription-service
```

---

### 2️⃣ Start Docker Containers

```bash
docker compose up -d --build
```

---

### 3️⃣ Install Dependencies (if needed)

```bash
docker compose run --rm app composer install
```

---

### 4️⃣ Generate Application Key

```bash
docker compose run --rm app php artisan key:generate
```

---

### 5️⃣ Run Migrations & Seeders

```bash
docker compose run --rm app php artisan migrate --seed
```

---

### 6️⃣ Clear Cache (Recommended)

```bash
docker compose run --rm app php artisan route:clear
docker compose run --rm app php artisan cache:clear
docker compose run --rm app php artisan config:clear
```

---

## 📦 Subscription Rules (Business Logic)

* A user can take **Trial** only once
* Trial user **can shift to any paid package**
* When shifting from Trial → Paid:

  * Trial is automatically closed
  * New package becomes active
* If a **paid package is active**, user **cannot switch** to another package
* No overlapping subscriptions allowed (except Trial → Paid shift)

---

## 🔗 API Endpoints

Base URL (local):

```
http://localhost:8000/api
```

### 📌 List Packages

```
GET /packages
```

---

### 📌 Subscribe User

```
POST /subscribe
```

**Request Body (JSON – raw):**

```json
{
  "user_id": 1,
  "package_id": 2,
  "type": "Monthly"
}
```

Allowed `type` values:

* `Trial`
* `Monthly`

---

### 📌 Check Active Subscription

```
GET /subscription-status/{user_id}
```

---

### 📌 Subscription History

```
GET /subscription-history/{user_id}
```

---

## 🧪 Postman API Documentation

All APIs are documented and testable via Postman.

👉 **Postman Workspace Link:**

[https://.postman.co/workspace/LARAVEL-~c9355ef7-c769-4b89-a7a4-26c8f1f006f5/request/33759799-f8fc4270-9edd-43c6-96d8-4d0a17daaf84?action=share&creator=33759799](https://.postman.co/workspace/LARAVEL-~c9355ef7-c769-4b89-a7a4-26c8f1f006f5/request/33759799-f8fc4270-9edd-43c6-96d8-4d0a17daaf84?action=share&creator=33759799)

---

## ✅ Useful Commands

```bash
# Stop containers & remove volumes
docker compose down -v

# Rebuild containers
docker compose up -d --build

# View routes
docker compose run --rm app php artisan route:list

# Enter app container shell
docker compose exec app bash
```

---

## 📌 Notes

* Always send API requests using **raw JSON** in Postman
* Ensure `Content-Type: application/json` header is set
* This service is designed as a **microservice**, independent of auth

---

## 👨‍💻 Author

Built for backend subscription management challenge 🚀
