# SPK Skripsi Backend (Laravel API)

Backend API untuk Sistem Pendukung Keputusan (SPK) Penentuan Topik Skripsi Mahasiswa Jurusan TIK Prodi TI PNJ menggunakan metode WASPAS.

## Tech Stack

- Laravel 13
- MySQL
- Sanctum Authentication
- Spatie Permission (Role & Permission)
- REST API
- WASPAS Method

---

## Features

### Mahasiswa
- Register
- Login
- Logout
- Profile Mahasiswa
- Isi Kuesioner
- Hasil Rekomendasi Topik Skripsi
- Riwayat Rekomendasi

### Admin
- CRUD Kriteria
- CRUD Topik Skripsi (Alternatif)
- CRUD Pertanyaan
- Role-based Access Control

---

## Installation

Clone project:

```bash
git clone https://github.com/Dbagustri/spk-skripsi-be.git
cd spk-skripsi-be
```

Install dependency:

```bash
composer install
```

Copy env:

```bash
cp .env.example .env
```

Generate key:

```bash
php artisan key:generate
```

Setup database di `.env`

Run migration:

```bash
php artisan migrate --seed
```

Run server:

```bash
php artisan serve
```

---

## Default Admin

```text
Email: admin2@spk.com
Password: admin12345
```

---

# API Testing

Base URL:

```text
http://127.0.0.1:8000/api
```

---

## Authentication

### Register

```http
POST /auth/register
```

Body:

```json
{
    "name": "Diandra",
    "email": "diandra@mail.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

---

### Login

```http
POST /auth/login
```

Body:

```json
{
    "email": "diandra@mail.com",
    "password": "password123"
}
```

Response:

```json
{
    "success": true,
    "data": {
        "token": "TOKEN"
    }
}
```

Gunakan token:

```text
Authorization:
Bearer TOKEN
```

---

## Student Profile

### Create Profile

```http
POST /student-profile
```

Body:

```json
{
    "nim": "2207411001",
    "semester": 8,
    "ipk": 3.75,
    "minat_karir": "Software Engineer"
}
```

---

## Questions

### Get Questions

```http
GET /questions
```

---

## Questionnaire

### Submit Answers

```http
POST /questionnaire
```

Body:

```json
{
    "answers": [
        {
            "question_id": 1,
            "answer_value": 5
        },
        {
            "question_id": 2,
            "answer_value": 4
        },
        {
            "question_id": 3,
            "answer_value": 5
        }
    ]
}
```

---

## Recommendation

### Calculate Recommendation

```http
GET /recommendation
```

---

### Recommendation History

```http
GET /recommendation/history
```

---

## Admin API

Admin only:

### Criteria

```http
GET /admin/criteria
POST /admin/criteria
PUT /admin/criteria/{id}
DELETE /admin/criteria/{id}
```

### Alternatives

```http
GET /admin/alternatives
POST /admin/alternatives
PUT /admin/alternatives/{id}
DELETE /admin/alternatives/{id}
```

### Questions

```http
GET /admin/questions
POST /admin/questions
PUT /admin/questions/{id}
DELETE /admin/questions/{id}
```

---

## WASPAS Formula

Qi dihitung menggunakan metode WASPAS:

- Weighted Sum Model (WSM)
- Weighted Product Model (WPM)

Final score:

Qi = 0.5(Q1) + 0.5(Q2)

---

## Author

Diandra Bagustri
