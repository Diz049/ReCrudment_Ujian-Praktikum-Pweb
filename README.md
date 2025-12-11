#Aplikasi CRUD Lamaran Pekerjaan

Aplikasi berbasis PHP dan MySQL yang digunakan untuk mengelola lowongan pekerjaan dan lamaran. Sistem ini dikembangkan menggunakan XAMPP, MySQL, dan Bootstrap.


## Fitur Utama

* Login dengan dua jenis pengguna: Admin dan Applicant
* Admin dapat menambah, mengubah, dan menghapus data lowongan
* Applicant dapat melihat lowongan dan mengirim lamaran
* Sistem upload CV (PDF atau gambar)
* Penyimpanan data menggunakan MySQL


## Struktur Folder

recruit_crud/
├── crud/
│   ├── uploads/
│   │   └── cv/            # Folder upload CV
│   └── file PHP lain
├── database/
│   └── db_jobless.sql     # File database
├── connection.example.php
└── .gitignore
```


## Cara Instalasi

1. Pastikan XAMPP sudah terpasang dan aktifkan Apache serta MySQL.

2. Pindahkan folder proyek ke direktori:

   ```
   C:\xampp\htdocs\
   ```

3. Buat database baru di phpMyAdmin dengan nama:

   ```
   db_jobless
   ```

4. Import file:

   ```
   database/db_jobless.sql
   ```

5. Salin file `connection.example.php` menjadi `connection.php` dan sesuaikan konfigurasi:

   ```php
   <?php
   $conn = mysqli_connect('localhost', 'root', '', 'db_jobless');
   ?>
   ```

6. Buka aplikasi melalui browser:

   ```
   http://localhost/recruit_crud/
   ```

---

## Akun Contoh

Admin:
username: admin
password: admin123

Applicant:
username: Diaz
password: login123

---

## Teknologi yang Digunakan

* PHP
* MySQL
* HTML dan CSS
* Bootstrap
* XAMPP