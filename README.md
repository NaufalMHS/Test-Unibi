## ⚙️ Instalasi Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal:

### 1. Clone Repositori

```bash
git clone https://github.com/namamu/nama-project.git
cd nama-project
```

### 2. Install Dependensi Backend

```bash
composer install
```

### 3. Install Dependensi Frontend (jika pakai Vite atau Mix)

```bash
npm install
npm run dev
```

### 4. Salin File .env dan Konfigurasi

```bash
cp .env.example .env
```

Edit file `.env` dan atur koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=username_database
DB_PASSWORD=password_database
```

### 5. Generate APP_KEY

```bash
php artisan key:generate
```

### 6. Jalankan Migrasi dan Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 7. Jalankan Server Laravel

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://localhost:8000`.

---

### 8. Login

```bash
Email : admin@example.com
password : password123

Email : user@example.com
password : password123


Email : user1@example.com
password : password123
