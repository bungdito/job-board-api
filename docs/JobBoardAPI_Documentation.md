# Job Board API Documentation

## Overview

The Job Board API allows users to manage job listings with advanced filtering options. This API is built using Laravel 12 and provides endpoints for creating, reading, updating, and deleting job listings.

## Installation & Setup

### 1. Clone the Repository

```bash
 git clone https://github.com/bungdito/job-board-api.git
 cd job-board-api
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Set Up Environment

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` file with database credentials.

### 4. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

### 5. Start the Server

```bash
php artisan serve
```

---

## API Endpoints

### 1. Get All Job Listings (with Filtering)

**Endpoint:** `GET /api/jobs`
**Query Parameters:**

- `filter` → Apply advanced filtering (e.g., `status=published`)

**Example Request:**

```bash
curl -X GET "http://localhost:8000/api/jobs?filter=job_type=full-time"
```

---

### 2. Create a Job Listing

**Endpoint:** `POST /api/jobs`
**Request Body:**

```json
{
    "title": "Senior Laravel Developer",
    "description": "Develop and maintain Laravel applications.",
    "company_name": "TechCorp",
    "salary_min": 60000,
    "salary_max": 90000,
    "is_remote": true,
    "job_type": "full-time",
    "status": "published",
    "published_at": "2024-03-01",
    "languages": [1, 2],
    "locations": [1],
    "categories": [1]
}
```

**Example Request:**

```bash
curl -X POST "http://localhost:8000/api/jobs"      -H "Content-Type: application/json"      -d @job_data.json
```

---

### 3. Get a Specific Job Listing

**Endpoint:** `GET /api/jobs/{id}`
**Example Request:**

```bash
curl -X GET "http://localhost:8000/api/jobs/1"
```

---

### 4. Update a Job Listing

**Endpoint:** `PUT /api/jobs/{id}`
**Example Request:**

```json
{
    "title": "Updated Laravel Developer",
    "salary_min": 70000,
    "salary_max": 100000
}
```

```bash
curl -X PUT "http://localhost:8000/api/jobs/1"      -H "Content-Type: application/json"      -d @update_job.json
```

---

### 5. Delete a Job Listing

**Endpoint:** `DELETE /api/jobs/{id}`
**Example Request:**

```bash
curl -X DELETE "http://localhost:8000/api/jobs/1"
```

---

## Using Postman

1. **Import Postman Collection**

   - Download [Postman Collection](sandbox:/mnt/data/JobBoardAPI.postman_collection.json)
   - Open **Postman**, go to **Import**, and upload the file.
   - Update the `base_url` variable if needed.

2. **Run API Requests**

   - Select an endpoint and click **Send**.

---

## Conclusion

This API provides a full-featured job board management system with filtering capabilities. For more details, check the repository README or contact the development team.
