ini adalah `README.md` yang menjelaskan cara instalasi dan penggunaan.

-----

# ASN BerAKHLAK Backend

Backend untuk aplikasi ASN BerAKHLAK yang dibangun menggunakan Laravel.

## Fitur

  * **Autentikasi**: Login untuk pengguna dengan peran yang berbeda.
  * **Manajemen Master Data**: Kelola data Pengguna, Peran, OPD, Poin, dan Status.
  * **Manajemen Berita**: Buat, baca, perbarui, dan hapus berita, lengkap dengan manajemen status (Publish, Draft, Dibatalkan).
  * **Formulir OPD**: Pengguna OPD dapat mengirimkan formulir yang berisi gambar dan tautan video.
  * **Verifikasi Formulir**: Tim verifikasi dapat meninjau dan mengubah status formulir yang dikirimkan.
  * **Akumulasi Poin**: Sistem secara otomatis menghitung dan mengakumulasi poin berdasarkan formulir yang disetujui.

## Persyaratan Sistem

  * PHP \>= 8.2
  * Composer
  * Node.js & NPM
  * Database (MySQL, PostgreSQL, atau SQLite)

## Instalasi

1.  **Clone Repository**

    ```bash
    git clone https://github.com/ahmadfauzan03/asn_berakhlak_backend.git
    cd ASN_BERAKHLAK_backend
    ```

2.  **Instalasi Dependensi**
    Instal dependensi PHP dengan Composer.

    ```bash
    composer install
    ```

    Instal dependensi JavaScript dengan NPM.

    ```bash
    npm install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env`.

    ```bash
    cp .env.example .env
    ```

    Buat kunci aplikasi baru.

    ```bash
    php artisan key:generate
    ```

4.  **Konfigurasi Database**
    Buka file `.env` dan sesuaikan pengaturan database Anda (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5.  **Migrasi dan Seeding Database**
    Jalankan migrasi untuk membuat tabel database dan seeding untuk mengisi data awal (termasuk peran, pengguna default, dll.).

    ```bash
    php artisan migrate --seed
    ```

6.  **Buat Symbolic Link untuk Storage**
    Perintah ini akan membuat tautan dari `public/storage` ke `storage/app/public` agar file yang diunggah dapat diakses.

    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server**
    Jalankan server pengembangan Laravel.

    ```bash
    php artisan serve
    ```

    Jalankan Vite untuk kompilasi aset front-end.

    ```bash
    npm run dev
    ```

    Aplikasi Anda sekarang akan berjalan di `http://127.0.0.1:8000`.

## Penggunaan

### Pengguna Default

Aplikasi ini dilengkapi dengan beberapa pengguna default dengan peran yang berbeda. Anda dapat menemukannya di `database/seeders/UserSeeder.php`.

| Username          | Password           | Peran             |
| ----------------- | ------------------ | ----------------- |
| `super admin`     | `superadmin123`    | Super Admin       |
| `admin`           | `admin1233456`     | Admin             |
| `tim verifikasi`  | `timverifikasi1234`| Tim Verifikasi    |
| `BKD`             | `BKD12345`         | Pengguna OPD      |
| `BKBP`            | `BKBP123`          | Pengguna OPD      |
| *(dan pengguna OPD lainnya)* | *lihat seeder* | Pengguna OPD |

### Endpoint API

Berikut adalah beberapa endpoint API utama. Untuk daftar lengkap, silakan lihat file `routes/api.php`.

  * **POST** `/api/login`: Login untuk mendapatkan token otentikasi.
    ```json
    {
        "username": "super admin",
        "password": "superadmin123"
    }
    ```
  * **GET** `/api/berita`: (Publik) Melihat daftar berita yang sudah di-publish.
  * **GET** `/api/akumulasi-total-poin`: (Publik) Melihat akumulasi total poin untuk semua OPD.

Endpoint yang memerlukan autentikasi harus menyertakan token Bearer di header `Authorization`.

  * **POST** `/api/logout`: (Memerlukan Autentikasi) Logout pengguna.
  * **PUT** `/api/update-password`: (Memerlukan Autentikasi) Memperbarui password pengguna yang sedang login.
  * **GET** `/api/form_opd`: (Pengguna OPD) Melihat riwayat formulir yang telah dikirim.
  * **POST** `/api/form_opd`: (Pengguna OPD) Mengirimkan formulir baru.
  * **PUT** `/api/form-opd/{id}/update-status`: (Tim Verifikasi) Memperbarui status formulir.

### Peran Pengguna

  * **Super Admin**: Memiliki akses penuh ke semua fitur, termasuk manajemen data master.
  * **Admin**: Dapat mengelola berita (membuat, mengedit, mempublikasikan).
  * **Tim Verifikasi**: Dapat melihat semua formulir OPD dan melakukan verifikasi (menyetujui atau menolak).
  * **Pengguna OPD**: Dapat mengisi dan mengirimkan formulir penilaian untuk OPD mereka masing-masing.



### Dokumentasi API Endpoint

Berikut adalah rincian lengkap dari semua endpoint yang tersedia di backend ASN BerAKHLAK.

---

### 1. Endpoint Publik

Endpoint ini dapat diakses tanpa perlu autentikasi.

| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `POST` | `/api/login` | Melakukan login untuk mendapatkan token autentikasi. |
| `GET` | `/api/akumulasi-total-poin` | Mengambil data akumulasi total poin dari semua OPD. |
| `GET` | `/api/akumulasi-total-poin/{id_user}` | Mengambil data akumulasi total poin untuk pengguna tertentu. |
| `GET` | `/api/berita` | Mengambil daftar semua berita yang berstatus "DI Posting". |
| `GET` | `/api/berita/{id}` | Mengambil detail dari satu berita berdasarkan ID. |

---

### 2. Endpoint Terotentikasi

Endpoint di bawah ini memerlukan token autentikasi (Bearer Token) yang valid pada header `Authorization`.

#### 2.1. Umum (Untuk Semua Peran yang Sudah Login)

| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `POST` | `/api/logout` | Logout pengguna dan menghapus token saat ini. |
| `PUT` | `/api/update-password` | Memperbarui password pengguna yang sedang login. |

#### 2.2. Peran: `super admin`

Pengguna dengan peran `super admin` memiliki akses penuh ke semua data master.

| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/peran` | Mendapatkan semua data peran. |
| `POST` | `/api/peran` | Menambahkan peran baru. |
| `GET` | `/api/peran/{id}` | Mendapatkan detail peran berdasarkan ID. |
| `PUT` | `/api/peran/{id}` | Memperbarui data peran. |
| `DELETE` | `/api/peran/{id}` | Menghapus data peran. |
| `GET` | `/api/user` | Mendapatkan semua data pengguna. |
| `POST` | `/api/user` | Menambahkan pengguna baru. |
| `GET` | `/api/user/{id}` | Mendapatkan detail pengguna berdasarkan ID. |
| `PUT` | `/api/user/{id}` | Memperbarui data pengguna. |
| `DELETE` | `/api/user/{id}` | Menghapus data pengguna. |
| `GET` | `/api/opd` | Mendapatkan semua data OPD. |
| `POST` | `/api/opd` | Menambahkan OPD baru. |
| `GET` | `/api/opd/{id}` | Mendapatkan detail OPD berdasarkan ID. |
| `PUT` | `/api/opd/{id}` | Memperbarui data OPD. |
| `DELETE` | `/api/opd/{id}` | Menghapus data OPD. |
| `GET` | `/api/poin` | Mendapatkan semua data poin. |
| `POST` | `/api/poin` | Menambahkan data poin baru. |
| `GET` | `/api/poin/{id}` | Mendapatkan detail poin berdasarkan ID. |
| `PUT` | `/api/poin/{id}` | Memperbarui data poin. |
| `DELETE` | `/api/poin/{id}` | Menghapus data poin. |
| `GET` | `/api/status` | Mendapatkan semua data status. |
| `POST` | `/api/status` | Menambahkan data status baru. |
| `GET` | `/api/status/{id}` | Mendapatkan detail status berdasarkan ID. |
| `PUT` | `/api/status/{id}` | Memperbarui data status. |
| `DELETE` | `/api/status/{id}` | Menghapus data status. |
| `GET` | `/api/status_berita` | Mendapatkan semua status berita. |
| `POST` | `/api/status_berita` | Menambahkan status berita baru. |
| `GET` | `/api/status_berita/{id}` | Mendapatkan detail status berita. |
| `PUT` | `/api/status_berita/{id}` | Memperbarui status berita. |
| `DELETE` | `/api/status_berita/{id}` | Menghapus status berita. |
| `POST` | `/api/berita` | Membuat berita baru (sebagai draft). |
| `DELETE` | `/api/berita/{id}` | Menghapus berita. |
| `PUT` | `/api/berita/{id}/status` | Memperbarui status sebuah berita (misal: dari draft ke publish). |
| `PUT` | `/api/berita/{id}/edit` | Mengedit konten berita yang masih berstatus draft. |

#### 2.3. Peran: `admin`

Pengguna dengan peran `admin` memiliki akses untuk mengelola berita.

| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/status_berita` | Mendapatkan semua status berita. |
| `POST` | `/api/status_berita` | Menambahkan status berita baru. |
| `GET` | `/api/status_berita/{id}` | Mendapatkan detail status berita. |
| `PUT` | `/api/status_berita/{id}` | Memperbarui status berita. |
| `DELETE` | `/api/status_berita/{id}` | Menghapus status berita. |
| `POST` | `/api/berita` | Membuat berita baru (sebagai draft). |
| `DELETE` | `/api/berita/{id}` | Menghapus berita. |
| `PUT` | `/api/berita/{id}/status` | Memperbarui status sebuah berita. |
| `PUT` | `/api/berita/{id}/edit` | Mengedit konten berita yang masih berstatus draft. |

#### 2.4. Peran: `tim verifikasi`

Pengguna dengan peran `tim verifikasi` dapat memverifikasi formulir yang dikirim oleh OPD.

| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `PUT` | `/api/form-opd/{id}/update-status` | Memperbarui status formulir OPD (misal: Di Terima, Di Proses, Di Tolak). |
| `GET` | `/api/form-opd/all-data` | Mendapatkan semua data formulir dari semua OPD. |
| `GET` | `/api/kriteria` | Mendapatkan semua data kriteria penilaian. |
| `POST` | `/api/kriteria` | Menambahkan kriteria baru. |
| `GET` | `/api/kriteria/{id}` | Mendapatkan detail kriteria berdasarkan ID. |
| `PUT` | `/api/kriteria/{id}` | Memperbarui data kriteria. |
| `DELETE` | `/api/kriteria/{id}` | Menghapus data kriteria. |

#### 2.5. Peran: `pengguna opd`

Pengguna dengan peran `pengguna opd` dapat mengirimkan formulir penilaian untuk OPD-nya.

| Method | URI | Deskripsi |
| :--- | :--- | :--- |
| `GET` | `/api/form_opd` | Melihat riwayat formulir yang telah dikirim oleh pengguna. |
| `GET` | `/api/form_opd/bulan` | Melihat riwayat formulir berdasarkan bulan. |
| `POST` | `/api/form_opd` | Mengirimkan data formulir baru. |
| `POST` | `/api/form_opd/user/{id_user}/perbulan` | Memperbarui data formulir untuk pengguna per bulan. |
| `GET` | `/api/kriteria` | Mendapatkan semua data kriteria penilaian. |
| `POST` | `/api/kriteria` | Menambahkan kriteria baru. |
| `GET` | `/api/kriteria/{id}` | Mendapatkan detail kriteria berdasarkan ID. |
| `PUT` | `/api/kriteria/{id}` | Memperbarui data kriteria. |
| `DELETE` | `/api/kriteria/{id}` | Menghapus data kriteria. |