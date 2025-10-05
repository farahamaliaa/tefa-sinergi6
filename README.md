<h1 align='center'>Tefa SMK6</h1>

> Daftar API

# API Parent
API ini digunakan untuk mengelola data **Parent** dan relasinya dengan **Student** di sistem Tefa SMK6.  
Dukungan CRUD relasi Parent ↔ Student menggunakan Laravel API.

---

## 1. Get All Parent
**Method:** GET  
**URL:** `/api/parents`  

**Deskripsi:** Mengambil daftar semua parent beserta anak-anaknya.

**Contoh `curl`:**
```bash
curl -X GET http://localhost:8000/api/parents
```
## 2. Opsi Parent Detail
**Method:** GET  
**URL:** `/api/parents/{id}`

**Deskripsi:** Mengambil detail parent tertentu beserta daftar anaknya.

**Contoh `curl`:**
```bash
curl -X GET http://localhost:8000/api/parents/5
```

## 3. Attach Student To Parent
**Method:** POST  
**URL:** `/api/parents/{id}/students`

**Deskripsi:** Menghubungkan seorang student ke parent.

**Contoh `curl`:**
```bash
curl -X POST http://localhost:8000/api/parents/5/students \
     -H "Content-Type: application/json" \
     -d '{"student_id": 1}'
```
## 4. Detach Student from Parent
**Method:** DELETE  
**URL:** `/api/parents/{id}/students/{student_id}`

**Deskripsi:** Melepas relasi seorang student dari parent.

**Contoh `curl`:**
```bash
curl -X DELETE http://localhost:8000/api/parents/5/students/1
```
## ⚡ Catatan

Pastikan Parent dan Student sudah ada di database sebelum melakukan attach.

Endpoint menggunakan JSON format.

Jika menggunakan auth middleware, tambahkan header Authorization:

> [!CAUTION]
> Readme Ini akan saya ubah jadi wiki untuk mendokumentasikan semua api yg ada