# Dokumentasi REST API - Sistem Perpustakaan Digital Kampus

Base URL: `http://localhost:8000/api`  
Header Wajib: `Accept: application/json` (dan `Content-Type: application/json` untuk request dengan body JSON).

---

## Ringkasan Endpoint

| No | Method | Endpoint | Deskripsi | Status Code Sukses | Status Code Gagal |
|---|---|---|---|---|---|
| 1 | `GET` | `/api/books` | Mengambil daftar buku (filter `judul`, `category_id`, pagination) | `200 OK` | - |
| 2 | `GET` | `/api/books/{id}` | Mengambil detail satu buku | `200 OK` | `404 Not Found` |
| 3 | `POST` | `/api/books` | Menambahkan buku baru | `201 Created` | `422 Unprocessable Entity` |
| 4 | `PUT` | `/api/books/{id}` | Memperbarui data buku | `200 OK` | `422 Unprocessable Entity`, `404 Not Found` |
| 5 | `DELETE` | `/api/books/{id}` | Menghapus buku | `200 OK` | `404 Not Found` |
| 6 | `GET` | `/api/members` | Mengambil daftar anggota (pagination) | `200 OK` | - |
| 7 | `GET` | `/api/members/{id}` | Mengambil detail satu anggota | `200 OK` | `404 Not Found` |
| 8 | `GET` | `/api/loans` | Mengambil daftar transaksi peminjaman | `200 OK` | - |
| 9 | `POST` | `/api/loans` | Membuat transaksi peminjaman baru | `201 Created` | `422 Unprocessable Entity` |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | Mengubah status transaksi menjadi dikembalikan | `200 OK` | `404 Not Found` |
| 11 | `GET` | `/api/stats` | Mengambil statistik ringkas perpustakaan | `200 OK` | - |

---

## Rincian Endpoint & Contoh Response

### 1. `GET /api/books`
Mengambil daftar buku dengan format `BookResource` dan pagination. Mendukung query string `?judul=` dan `?category_id=`.

- **Query Parameters (opsional):**
  - `judul` (string): filter pencarian nama buku (partial match `LIKE`).
  - `category_id` (integer): filter ID kategori.
  - `page` (integer): nomor halaman (default: 1).

- **Response (`200 OK`):**
```json
{
  "data": [
    {
      "id": 1,
      "judul": "Laskar Pelangi",
      "penulis": "Andrea Hirata",
      "penerbit": "Bentang Pustaka",
      "tahun_terbit": 2005,
      "isbn": "978-979-1227-78-6",
      "stok": 10,
      "sampul": null,
      "category": {
        "id": 1,
        "nama_kategori": "Novel"
      },
      "created_at": "2026-09-26T10:00:00.000000Z",
      "updated_at": "2026-09-26T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/books?page=1",
    "last": "http://localhost:8000/api/books?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 2. `GET /api/books/{id}`
Mengambil detail satu buku berdasarkan ID.

- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 1,
    "judul": "Laskar Pelangi",
    "penulis": "Andrea Hirata",
    "penerbit": "Bentang Pustaka",
    "tahun_terbit": 2005,
    "isbn": "978-979-1227-78-6",
    "stok": 10,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Novel"
    },
    "created_at": "2026-09-26T10:00:00.000000Z",
    "updated_at": "2026-09-26T10:00:00.000000Z"
  }
}
```

- **Response Gagal (`404 Not Found`):**
```json
{
  "message": "Record not found."
}
```

---

### 3. `POST /api/books`
Menambahkan data buku baru menggunakan validasi `StoreBookRequest`.

- **Request Body (JSON):**
```json
{
  "judul": "Bumi Manusia",
  "penulis": "Pramoedya Ananta Toer",
  "penerbit": "Hasta Mitra",
  "tahun_terbit": 1980,
  "isbn": "978-979-97312-3-4",
  "stok": 5,
  "category_id": 1
}
```

- **Response Sukses (`201 Created`):**
```json
{
  "data": {
    "id": 2,
    "judul": "Bumi Manusia",
    "penulis": "Pramoedya Ananta Toer",
    "penerbit": "Hasta Mitra",
    "tahun_terbit": 1980,
    "isbn": "978-979-97312-3-4",
    "stok": 5,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Novel"
    },
    "created_at": "2026-10-12T00:20:00.000000Z",
    "updated_at": "2026-10-12T00:20:00.000000Z"
  }
}
```

- **Response Validasi Gagal (`422 Unprocessable Entity`):**
```json
{
  "message": "Judul buku wajib diisi. (and 3 more errors)",
  "errors": {
    "judul": ["Judul buku wajib diisi."],
    "penulis": ["Nama penulis wajib diisi."],
    "category_id": ["Kategori wajib dipilih."]
  }
}
```

---

### 4. `PUT /api/books/{id}`
Memperbarui data buku.

- **Request Body (JSON):**
```json
{
  "judul": "Bumi Manusia (Edisi Baru)",
  "penulis": "Pramoedya Ananta Toer",
  "penerbit": "Lentera Dipantara",
  "tahun_terbit": 2005,
  "isbn": "978-979-97312-3-4",
  "stok": 8,
  "category_id": 1
}
```

- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 2,
    "judul": "Bumi Manusia (Edisi Baru)",
    "penulis": "Pramoedya Ananta Toer",
    "penerbit": "Lentera Dipantara",
    "tahun_terbit": 2005,
    "isbn": "978-979-97312-3-4",
    "stok": 8,
    "sampul": null,
    "category": {
      "id": 1,
      "nama_kategori": "Novel"
    },
    "created_at": "2026-10-12T00:20:00.000000Z",
    "updated_at": "2026-10-12T00:22:00.000000Z"
  }
}
```

---

### 5. `DELETE /api/books/{id}`
Menghapus buku berdasarkan ID.

- **Response Sukses (`200 OK`):**
```json
{
  "message": "Buku berhasil dihapus."
}
```

---

### 6. `GET /api/members`
Mengambil daftar anggota perpustakaan dengan pagination.

- **Response Sukses (`200 OK`):**
```json
{
  "data": [
    {
      "id": 1,
      "nama": "Ahmad Fauzi",
      "nim": "220101001",
      "email": "ahmad@student.pens.ac.id",
      "nomor_telepon": "081234567890",
      "alamat": "Jl. Raya ITS No. 1, Surabaya",
      "status": "aktif",
      "created_at": "2026-09-26T10:00:00.000000Z",
      "updated_at": "2026-09-26T10:00:00.000000Z"
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/members?page=1",
    "last": "http://localhost:8000/api/members?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 7. `GET /api/members/{id}`
Mengambil detail satu anggota perpustakaan.

- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 1,
    "nama": "Ahmad Fauzi",
    "nim": "220101001",
    "email": "ahmad@student.pens.ac.id",
    "nomor_telepon": "081234567890",
    "alamat": "Jl. Raya ITS No. 1, Surabaya",
    "status": "aktif",
    "created_at": "2026-09-26T10:00:00.000000Z",
    "updated_at": "2026-09-26T10:00:00.000000Z"
  }
}
```

---

### 8. `GET /api/loans`
Mengambil daftar seluruh transaksi peminjaman lengkap dengan relasi anggota, petugas, dan item buku.

- **Response Sukses (`200 OK`):**
```json
{
  "data": [
    {
      "id": 1,
      "member": {
        "id": 1,
        "nama": "Ahmad Fauzi"
      },
      "petugas": {
        "id": 1,
        "name": "Admin Perpustakaan"
      },
      "tanggal_pinjam": "2026-10-01",
      "tanggal_kembali": "2026-10-08",
      "tanggal_dikembalikan": null,
      "status": "dipinjam",
      "books": [
        {
          "id": 1,
          "judul": "Laskar Pelangi"
        }
      ]
    }
  ],
  "links": {
    "first": "http://localhost:8000/api/loans?page=1",
    "last": "http://localhost:8000/api/loans?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

---

### 9. `POST /api/loans`
Membuat transaksi peminjaman baru (dapat mencakup beberapa buku dalam satu transaksi).

- **Request Body (JSON):**
```json
{
  "member_id": 1,
  "user_id": 1,
  "tanggal_pinjam": "2026-10-12",
  "tanggal_kembali": "2026-10-19",
  "book_ids": [1]
}
```

- **Response Sukses (`201 Created`):**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Ahmad Fauzi"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-10-12",
    "tanggal_kembali": "2026-10-19",
    "tanggal_dikembalikan": null,
    "status": "dipinjam",
    "books": [
      {
        "id": 1,
        "judul": "Laskar Pelangi"
      }
    ]
  }
}
```

- **Response Validasi Gagal (`422 Unprocessable Entity`):**
```json
{
  "message": "Pilih minimal satu buku. (and 1 more error)",
  "errors": {
    "tanggal_kembali": ["Tanggal kembali tidak boleh sebelum tanggal pinjam."],
    "book_ids": ["Pilih minimal satu buku."]
  }
}
```

---

### 10. `PUT /api/loans/{id}/kembalikan`
Mengubah status transaksi peminjaman menjadi `dikembalikan` dan mencatat `tanggal_dikembalikan` hari ini.

- **Response Sukses (`200 OK`):**
```json
{
  "data": {
    "id": 2,
    "member": {
      "id": 1,
      "nama": "Ahmad Fauzi"
    },
    "petugas": {
      "id": 1,
      "name": "Admin Perpustakaan"
    },
    "tanggal_pinjam": "2026-10-12",
    "tanggal_kembali": "2026-10-19",
    "tanggal_dikembalikan": "2026-10-12",
    "status": "dikembalikan",
    "books": [
      {
        "id": 1,
        "judul": "Laskar Pelangi"
      }
    ]
  }
}
```

---

### 11. `GET /api/stats`
Mengambil data ringkasan statistik operasional perpustakaan.

- **Response Sukses (`200 OK`):**
```json
{
  "total_buku": 12,
  "total_anggota": 45,
  "peminjaman_aktif": 3
}
```
