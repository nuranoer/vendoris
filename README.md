# 🏢 VENDORIS — Vendor Information & Reporting System

**VENDORIS** adalah sistem backend berbasis **Laravel** yang dikembangkan untuk membantu **PT. Maju Karya** dalam melakukan **seleksi, manajemen, dan analisis vendor** secara efisien.
Sistem ini menggantikan pencatatan manual di Excel dengan API modern yang dilengkapi autentikasi JWT, CRUD data vendor, serta fitur reporting (ranking dan perubahan harga).

---

## ⚙️ Teknologi yang Digunakan

| Komponen           | Teknologi                            |
| ------------------ | ------------------------------------ |
| Bahasa Pemrograman | PHP 8.2+                             |
| Framework          | Laravel 12                           |
| Database           | MySQL 8.x                            |
| Autentikasi        | JWT (php-open-source-saver/jwt-auth) |
| API Format         | RESTful JSON                         |
| Server Lokal       | Artisan (`php artisan serve`)        |

---

## 📦 Struktur Folder Penting

```
app/
 ├── Http/
 │   ├── Controllers/Api/   # Controller utama API
 │   ├── Requests/          # Validasi FormRequest
 ├── Models/                # Model Eloquent ORM
database/
 ├── migrations/            # Struktur tabel (schema)
 ├── seeders/               # Seeder untuk data awal
routes/
 └── api.php                # Rute API endpoint
```

---

## 🚀 Instalasi & Konfigurasi Awal

### 1️⃣ Clone Repository

```bash
git clone https://github.com/username/vendoris.git
cd vendoris
```

### 2️⃣ Install Dependency

```bash
composer install
```

### 3️⃣ Buat File `.env`

```bash
cp .env.example .env
```

### 4️⃣ Generate Key Laravel

```bash
php artisan key:generate
```

### 5️⃣ Konfigurasi Database di `.env`

Pastikan MySQL berjalan dan buat database baru (misal: `vendoris_db`)

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vendoris_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🔐 Setup JWT Authentication

### 1️⃣ Install Library JWT

Pastikan ekstensi **Sodium** aktif di PHP (cek dengan `php -m | findstr sodium`).

```bash
composer require php-open-source-saver/jwt-auth:^2.8
```

### 2️⃣ Publish Config

```bash
php artisan vendor:publish --provider="PHPOpenSourceSaver\\JWTAuth\\Providers\\LaravelServiceProvider"
```

### 3️⃣ Generate Secret Key

```bash
php artisan jwt:secret
```

### 4️⃣ Update `config/auth.php`

Tambahkan guard JWT:

```php
'defaults' => [
    'guard' => 'api',
    'passwords' => 'users',
],

'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'jwt',
        'provider' => 'users',
    ],
],
```

---

## 🧱 Migrasi & Seeder

### 1️⃣ Jalankan Migration

```bash
php artisan migrate
```

### 2️⃣ Jalankan Seeder

Seeder sudah modular per tabel (`UsersTableSeeder`, `VendorsTableSeeder`, dll).

```bash
php artisan db:seed
```

### 3️⃣ Data Awal yang Terbuat

| Tabel             | Isi Contoh                                               |
| ----------------- | -------------------------------------------------------- |
| users             | [admin@example.com](mailto:admin@example.com) / password |
| vendors           | V01 - Vendor 1, V02 - Vendor 2, V03 - Vendor 3           |
| items             | IT01 - Item 1, IT02 - Item 2, IT03 - Item 3              |
| vendor_items      | Vendor-item map dengan harga berjalan                    |
| price_histories   | Histori harga untuk analisis up/down                     |
| transactions      | TRX-001, TRX-002, TRX-003                                |
| transaction_items | Detail tiap transaksi                                    |

---

## ▶️ Menjalankan Server

```bash
php artisan serve
```

Server akan aktif di:
**[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🧾 Daftar Endpoint API

### 🔹 AUTH

| Method | Endpoint             | Deskripsi                    |
| ------ | -------------------- | ---------------------------- |
| `POST` | `/api/auth/register` | Registrasi user baru         |
| `POST` | `/api/auth/login`    | Login dan dapatkan JWT token |
| `GET`  | `/api/auth/me`       | Lihat profil user aktif      |
| `POST` | `/api/auth/logout`   | Logout dan revoke token      |
| `POST` | `/api/auth/refresh`  | Refresh token JWT            |

#### Contoh Login

```bash
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "password"
}
```

Respon:

```json
{
  "status": true,
  "token": "eyJ0eXAiOiJKV1QiLCJh...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

---

### 🔹 CRUD Vendor

| Method   | Endpoint            | Deskripsi          |
| -------- | ------------------- | ------------------ |
| `GET`    | `/api/vendors`      | List semua vendor  |
| `POST`   | `/api/vendors`      | Tambah vendor baru |
| `GET`    | `/api/vendors/{id}` | Detail vendor      |
| `PUT`    | `/api/vendors/{id}` | Update vendor      |
| `DELETE` | `/api/vendors/{id}` | Hapus vendor       |

---

### 🔹 CRUD Item

| Method   | Endpoint          | Deskripsi        |
| -------- | ----------------- | ---------------- |
| `GET`    | `/api/items`      | List semua item  |
| `POST`   | `/api/items`      | Tambah item baru |
| `GET`    | `/api/items/{id}` | Detail item      |
| `PUT`    | `/api/items/{id}` | Update item      |
| `DELETE` | `/api/items/{id}` | Hapus item       |

---

### 🔹 Vendor Items & Price History

| Method | Endpoint                          | Deskripsi                        |
| ------ | --------------------------------- | -------------------------------- |
| `POST` | `/api/vendor-items/attach`        | Hubungkan vendor dengan item     |
| `POST` | `/api/vendor-items/price-history` | Tambah histori harga vendor-item |

Contoh:

```json
POST /api/vendor-items/price-history
{
  "vendor_id": 1,
  "item_id": 1,
  "price": 15000,
  "effective_date": "2025-10-01"
}
```

---

### 🔹 Transaksi

| Method | Endpoint                 | Deskripsi             |
| ------ | ------------------------ | --------------------- |
| `GET`  | `/api/transactions`      | Lihat semua transaksi |
| `POST` | `/api/transactions`      | Tambah transaksi baru |
| `GET`  | `/api/transactions/{id}` | Detail transaksi      |

Contoh tambah transaksi:

```json
POST /api/transactions
{
  "vendor_id": 1,
  "kode_transaksi": "TRX-100",
  "tanggal_transaksi": "2025-10-29",
  "items": [
    {"item_id": 1, "qty": 2, "harga_satuan": 10000},
    {"item_id": 2, "qty": 1, "harga_satuan": 27000}
  ]
}
```

---

### 🔹 Reporting

| Method | Endpoint                    | Deskripsi                                     |
| ------ | --------------------------- | --------------------------------------------- |
| `GET`  | `/api/reports/vendor-items` | Daftar item yang disediakan tiap vendor       |
| `GET`  | `/api/reports/vendor-rank`  | Ranking vendor berdasarkan jumlah transaksi   |
| `GET`  | `/api/reports/price-change` | Analisis kenaikan/penurunan harga vendor-item |

---

## 🧪 Testing dengan Postman

### 1️⃣ Login untuk Dapat Token

* **POST** → `http://127.0.0.1:8000/api/auth/login`
* Body:

  ```json
  {"email":"admin@example.com","password":"password"}
  ```
* Copy nilai dari field `"token"`

### 2️⃣ Set Authorization di Postman

* Di setiap request, buka tab **Headers** → tambah:

  ```
  Authorization: Bearer {token}
  ```

  Contoh:

  ```
  Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGci...
  ```

### 3️⃣ Coba Endpoint

* GET `/api/vendors` → lihat daftar vendor
* GET `/api/reports/vendor-rank` → lihat peringkat vendor berdasarkan transaksi
* GET `/api/reports/price-change` → lihat status up/down harga item

---

## 📊 Contoh Output Report

#### 🔸 `/api/reports/vendor-rank`

```json
{
  "status": true,
  "message": "data ditemukan",
  "data": [
    {
      "id_vendor": 1,
      "kode_vendor": "V01",
      "nama_vendor": "Vendor 1",
      "jumlah_transaksi": 2
    },
    {
      "id_vendor": 2,
      "kode_vendor": "V02",
      "nama_vendor": "Vendor 2",
      "jumlah_transaksi": 1
    }
  ]
}
```

#### 🔸 `/api/reports/price-change`

```json
{
  "status": true,
  "message": "data ditemukan",
  "data": [
    {
      "id_vendor": 1,
      "kode_vendor": "V01",
      "nama_vendor": "Vendor 1",
      "item": [
        {
          "id_item": 1,
          "kode_item": "IT01",
          "nama_item": "Item 1",
          "harga_sebelum": 15000,
          "harga_sekarang": 10000,
          "selisih": 5000,
          "rate": 33.33,
          "status": "down"
        }
      ]
    }
  ]
}
```

---

## 🧠 Tips Pengembangan

* Gunakan `php artisan route:list` untuk melihat semua endpoint.
* Simpan Postman Collection untuk testing tim QA.
* Pastikan timezone disesuaikan di `.env`:

  ```
  APP_TIMEZONE=Asia/Jakarta
  ```

---

## 📜 Lisensi

MIT License © 2025 **PT. Maju Karya**

> “Transforming Vendor Selection with Smart Data-Driven Reporting”
