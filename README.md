# 📌 Job Listing API - Laravel 12

## 🚀 Introduction
This project is a **Job Listing API** built using **Laravel 12**. It provides CRUD operations and advanced filtering capabilities for job listings, including relationships with **languages, locations, categories,** and **dynamic attributes (EAV model)**.

This API now **fully supports complex filtering** with **AND/OR operators and Grouping**, allowing flexible and efficient queries.  

---

## 📌 Features
✅ **CRUD Operations** for Job Listings  
✅ **Advanced Filtering (AND/OR + Grouping)**  
✅ **Filtering by Relationships (Languages, Locations, Categories)**  
✅ **Dynamic Attributes Filtering (EAV System)**  
✅ **RESTful API** with proper status codes**  
✅ **Postman Collection for Testing** (📂 `docs/JobBoardAPI.postman_collection.json`)  
✅ **Comprehensive API Documentation** (📂 `docs/JobBoardAPI_Documentation.md`)  

---

## 📌 Technologies Used
- **Laravel 12** (PHP Framework)
- **MySQL** (Database)
- **Eloquent ORM**
- **Postman** (For API testing)
- **Composer** (PHP Dependency Manager)

---

## 📌 Installation Guide

### **1️⃣ Clone the Repository**
```bash
git clone https://github.com/bungdito/job-board-api.git
cd job-board-api
```

### **2️⃣ Install Dependencies**
```bash
composer install
```

### **3️⃣ Set Up Environment**
1. Copy `.env.example` to `.env`
```bash
cp .env.example .env
```
2. Open `.env` file and configure the **database settings**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_board
DB_USERNAME=root
DB_PASSWORD=
```

### **4️⃣ Generate Application Key**
```bash
php artisan key:generate
```

### **5️⃣ Run Migrations & Seed Database**
```bash
php artisan migrate --seed
```

### **6️⃣ Start the Laravel Development Server**
```bash
php artisan serve
```
Your API will be available at:
```
http://127.0.0.1:8000
```

---

## 📌 API Documentation

📌 **Location:** `docs/JobBoardAPI_Documentation.md`  

### **Import Postman Collection**
📌 **Location:** `docs/JobBoardAPI.postman_collection.json`  

1. Open **Postman**
2. Click **Import** → **Upload Files**
3. Select `docs/JobBoardAPI.postman_collection.json`
4. Click **Import**
5. Use **`{{base_url}}`** as `http://127.0.0.1:8000` in Postman Environment.

---

## API Routes & Example Responses

### 1. Get All Job Listings
**Endpoint:** `GET /api/jobs`

**Example Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Senior Laravel Developer",
      "company_name": "TechCorp",
      "salary_min": 60000,
      "salary_max": 90000,
      "is_remote": true,
      "job_type": "full-time",
      "status": "published",
      "languages": ["PHP", "JavaScript"],
      "locations": ["New York"],
      "categories": ["Software Engineering"]
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/jobs?page=1",
    "last": "http://localhost:8000/api/jobs?page=10",
    "prev": null,
    "next": "http://localhost:8000/api/jobs?page=2"
  }
}
```

### 2. Create a Job Listing
**Endpoint:** `POST /api/jobs`

**Example Response:**
```json
{
  "id": 2,
  "title": "Backend Developer",
  "company_name": "DevCorp",
  "salary_min": 50000,
  "salary_max": 80000,
  "is_remote": false,
  "job_type": "contract",
  "status": "draft",
  "languages": ["Python"],
  "locations": ["San Francisco"],
  "categories": ["Finance"]
}
```

### 3. Get a Specific Job Listing
**Endpoint:** `GET /api/jobs/{id}`

**Example Response:**
```json
{
  "id": 1,
  "title": "Senior Laravel Developer",
  "company_name": "TechCorp",
  "salary_min": 60000,
  "salary_max": 90000,
  "is_remote": true,
  "job_type": "full-time",
  "status": "published",
  "languages": ["PHP", "JavaScript"],
  "locations": ["New York"],
  "categories": ["Software Engineering"]
}
```

### 4. Update a Job Listing
**Endpoint:** `PUT /api/jobs/{id}`

**Example Response:**
```json
{
  "id": 1,
  "title": "Updated Laravel Developer",
  "company_name": "TechCorp",
  "salary_min": 70000,
  "salary_max": 100000,
  "is_remote": true,
  "job_type": "full-time",
  "status": "published"
}
```

### 5. Delete a Job Listing
**Endpoint:** `DELETE /api/jobs/{id}`

**Example Response:**
```json
{
  "message": "Job deleted successfully"
}
```

## 📌 Advanced Filtering

### 1️⃣ Basic Filtering by Field Type
| Field Type       | Supported Operators |
|-----------------|--------------------|
| **Text Fields** (`title`, `description`) | `=`, `!=`, `LIKE` |
| **Number Fields** (`salary_min`, `salary_max`) | `=`, `!=`, `>`, `<`, `>=`, `<=` |
| **Boolean Fields** (`is_remote`) | `=`, `!=` |
| **Enum Fields** (`job_type`, `status`) | `=`, `!=`, `IN` |
| **Date Fields** (`published_at`, `created_at`) | `=`, `!=`, `>`, `<`, `>=`, `<=` |

---

### 2️⃣ Relationship Filtering
| Relationship | Supported Operators |
|-------------|---------------------|
| **Languages** (PHP, JavaScript) | `=`, `HAS_ANY`, `IS_ANY`, `EXISTS` |
| **Locations** (New York, Remote) | `=`, `HAS_ANY`, `IS_ANY`, `EXISTS` |
| **Categories** (Engineering, Marketing) | `=`, `HAS_ANY`, `IS_ANY`, `EXISTS` |

---

### 3️⃣ EAV Filtering (Dynamic Attributes)
| Attribute Type | Supported Operators |
|---------------|--------------------|
| **Text Attributes** | `=`, `!=`, `LIKE` |
| **Number Attributes** | `=`, `!=`, `>`, `<`, `>=`, `<=` |
| **Boolean Attributes** | `=`, `!=` |
| **Select Attributes** | `=`, `!=`, `IN` |

---

### 4️⃣ **AND/OR Filtering with Grouping** (NEW! 🚀)
Now you can filter with **AND/OR conditions** using **grouping syntax**.

#### **Example Query:**
```
GET /api/job-listings?filter=(job_type=full-time AND (languages HAS_ANY (PHP,JavaScript))) AND (locations IS_ANY (New York,Remote)) AND attribute:years_experience>=3
```
#### **Generated SQL Query:**
```sql
SELECT * FROM job_listings
WHERE job_type = 'full-time'
AND (language IN ('PHP', 'JavaScript'))
AND (location IN ('New York', 'Remote'))
AND (EXISTS (SELECT * FROM job_listing_attribute_values WHERE attribute_id = 'years_experience' AND value >= 3));
```

---

## 📌 How to Run Tests
To run Laravel tests, use:
```bash
php artisan test
```

---

## 📌 Deployment Guide
For **production deployment**, configure **Nginx/Apache** and set up **.env** with database & queue settings.

1. **Set Up Production Database**
2. **Run Migrations**
```bash
php artisan migrate --seed
```
3. **Set File & Folder Permissions**
```bash
chmod -R 775 storage bootstrap/cache
```
4. **Run Laravel Queue (Optional)**
```bash
php artisan queue:work
```

---

## 📌 Contributing
Contributions are welcome! To contribute:
1. Fork this repository.
2. Create a new branch (`feature/new-feature`).
3. Commit your changes.
4. Push to your fork and create a pull request.

---

## 📌 License
This project is licensed under the **MIT License**.

---

## 📌 Author
GitHub: [bungdito](https://github.com/bungdito)  
Email: bungdito@gmail.com  
