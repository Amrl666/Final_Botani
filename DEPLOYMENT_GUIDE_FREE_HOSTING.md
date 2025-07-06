# 🚀 PANDUAN DEPLOYMENT WEB BOTANI KE HOSTING GRATIS

## 📋 DAFTAR ISI
1. [Persiapan Awal](#persiapan-awal)
2. [Pilihan Hosting Gratis](#pilihan-hosting-gratis)
3. [Deployment ke InfinityFree](#deployment-ke-infinityfree)
4. [Deployment ke 000WebHost](#deployment-ke-000webhost)
5. [Troubleshooting](#troubleshooting)
6. [Post-Deployment Checklist](#post-deployment-checklist)

---

## 🎯 PERSIAPAN AWAL

### Prerequisites
- ✅ Web Botani sudah siap (database clean, hanya admin user)
- ✅ File .env sudah dikonfigurasi untuk production
- ✅ Assets sudah di-build
- ✅ Composer dependencies terinstall
- ✅ Node.js & NPM terinstall (untuk build assets)

### File yang Perlu Disiapkan
```
botani_final/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/          # Document root
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

---

## 🌐 PILIHAN HOSTING GRATIS

### 1. **INFINITYFREE** (RECOMMENDED)
**Keunggulan:**
- ✅ Unlimited bandwidth & storage
- ✅ Free subdomain (.epizy.com)
- ✅ Free SSL certificate
- ✅ PHP 8.1 support
- ✅ MySQL database
- ✅ cPanel included
- ✅ No ads

**Limitasi:**
- ❌ No custom domain (hanya subdomain)
- ❌ Limited CPU resources
- ❌ Support terbatas

### 2. **000WEBHOST** (BY HOSTINGER)
**Keunggulan:**
- ✅ 1GB storage
- ✅ 10GB bandwidth
- ✅ Free subdomain (.000webhostapp.com)
- ✅ PHP 8.0 support
- ✅ MySQL database
- ✅ SSL included

**Limitasi:**
- ❌ 1GB storage limit
- ❌ 10GB bandwidth limit
- ❌ Sleep mode setelah 30 menit tidak aktif
- ❌ No custom domain

### 3. **ALTERNATIF LAIN**
- **AwardSpace**: 1GB storage, 5GB bandwidth
- **FreeHostia**: 250MB storage, 6GB bandwidth
- **Byethost**: 1GB storage, unlimited bandwidth

---

## 🚀 DEPLOYMENT KE INFINITYFREE

### Step 1: Daftar Akun
1. Buka [infinityfree.net](https://infinityfree.net)
2. Klik "Sign Up" atau "Create Account"
3. Isi form pendaftaran:
   - Username: `botani_admin`
   - Email: `your-email@gmail.com`
   - Password: `[STRONG_PASSWORD]`
4. Verifikasi email
5. Login ke dashboard

### Step 2: Buat Hosting Account
1. Di dashboard, klik "New Account"
2. Pilih "Free Hosting"
3. Isi form:
   - **Domain**: `botani.epizy.com` (atau pilihan lain)
   - **Password**: `[STRONG_PASSWORD]`
   - **Email**: `your-email@gmail.com`
4. Klik "Create Account"
5. Tunggu aktivasi (5-10 menit)

### Step 3: Setup Database
1. Login ke cPanel (link tersedia di dashboard)
2. Buka "MySQL Databases"
3. Buat database baru:
   - **Database Name**: `botani_admin_botani`
   - **Database User**: `botani_admin_botani`
   - **Password**: `[STRONG_PASSWORD]`
4. Catat informasi database:
   ```
   Host: sql.infinityfree.com
   Database: botani_admin_botani
   Username: botani_admin_botani
   Password: [STRONG_PASSWORD]
   ```

### Step 4: Upload File
1. Di cPanel, buka "File Manager"
2. Navigasi ke folder `htdocs/`
3. Upload semua file web Botani
4. Pastikan struktur folder:
   ```
   htdocs/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public/     # Document root
   ├── resources/
   ├── routes/
   ├── storage/
   ├── vendor/
   ├── .env
   └── artisan
   ```

### Step 5: Konfigurasi .env
1. Di File Manager, edit file `.env`
2. Update dengan konfigurasi production:
   ```env
   APP_NAME="Bo Tani"
   APP_ENV=production
   APP_KEY=base64:exF5ywZCpXWwyZvIoNmj/VacKvNfJaOEUNoPYq/b7pU=
   APP_DEBUG=false
   APP_URL=https://botani.epizy.com

   DB_CONNECTION=mysql
   DB_HOST=sql.infinityfree.com
   DB_PORT=3306
   DB_DATABASE=botani_admin_botani
   DB_USERNAME=botani_admin_botani
   DB_PASSWORD=[STRONG_PASSWORD]

   # WhatsApp API
   FONNTE_API_KEY=[YOUR_FONNTE_API_KEY]
   FONNTE_DEVICE_ID=[YOUR_DEVICE_ID]

   # File upload
   FILESYSTEM_DISK=public
   ```

### Step 6: Install Dependencies
1. Di cPanel, buka "Terminal" atau "SSH Access"
2. Jalankan perintah:
   ```bash
   cd htdocs
   composer install --no-dev --optimize-autoloader
   ```

### Step 7: Setup Permissions
1. Di File Manager, set permissions:
   ```bash
   storage/ → 755
   bootstrap/cache/ → 755
   .env → 644
   ```

### Step 8: Jalankan Migrasi
1. Di Terminal, jalankan:
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=AdminUserSeeder
   ```

### Step 9: Build Assets
1. Install Node.js dependencies:
   ```bash
   npm install
   npm run build
   ```

### Step 10: Cache Laravel
1. Jalankan perintah cache:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Step 11: Setup Document Root
1. Buat file `.htaccess` di root `htdocs/`:
   ```apache
   RewriteEngine On
   RewriteRule ^(.*)$ public/$1 [L]
   ```

### Step 12: Test Website
1. Buka website: `https://botani.epizy.com`
2. Test fitur utama:
   - ✅ Homepage loading
   - ✅ Admin login
   - ✅ Product catalog
   - ✅ Contact form
   - ✅ WhatsApp integration

---

## 🚀 DEPLOYMENT KE 000WEBHOST

### Step 1: Daftar Akun
1. Buka [000webhost.com](https://000webhost.com)
2. Klik "Create Website"
3. Isi form:
   - **Website Name**: `botani`
   - **Email**: `your-email@gmail.com`
   - **Password**: `[STRONG_PASSWORD]`
4. Verifikasi email

### Step 2: Setup Website
1. Login ke dashboard
2. Klik "Manage" pada website yang dibuat
3. Catat subdomain: `botani.000webhostapp.com`

### Step 3: Setup Database
1. Di dashboard, buka "Databases"
2. Buat database baru:
   - **Database Name**: `botani_db`
   - **Username**: `botani_user`
   - **Password**: `[STRONG_PASSWORD]`
3. Catat informasi database

### Step 4: Upload File
1. Di dashboard, buka "File Manager"
2. Upload semua file ke root directory
3. Pastikan struktur folder sama seperti InfinityFree

### Step 5: Konfigurasi .env
1. Edit file `.env` dengan database credentials 000WebHost
2. Update APP_URL ke subdomain 000WebHost

### Step 6: Install & Setup
1. Jalankan perintah yang sama seperti InfinityFree:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan db:seed --class=AdminUserSeeder
   npm install
   npm run build
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🔧 TROUBLESHOOTING

### Error 500 - Internal Server Error
**Penyebab:** Permissions atau .env salah
**Solusi:**
```bash
# Set permissions
chmod 755 storage/
chmod 755 bootstrap/cache/
chmod 644 .env

# Check error log
tail -f storage/logs/laravel.log
```

### Database Connection Error
**Penyebab:** Database credentials salah
**Solusi:**
1. Double-check database credentials di .env
2. Pastikan database sudah dibuat
3. Test connection via phpMyAdmin

### White Screen
**Penyebab:** PHP error atau missing dependencies
**Solusi:**
```bash
# Enable debug mode sementara
APP_DEBUG=true

# Check error log
# Reinstall dependencies
composer install --no-dev
```

### Assets Not Loading
**Penyebab:** Assets belum di-build
**Solusi:**
```bash
npm install
npm run build
```

### Upload File Error
**Penyebab:** Storage permissions
**Solusi:**
```bash
chmod 755 storage/app/public/
php artisan storage:link
```

---

## ✅ POST-DEPLOYMENT CHECKLIST

### Security Checklist
- [ ] APP_DEBUG=false
- [ ] APP_ENV=production
- [ ] Strong database password
- [ ] SSL certificate aktif
- [ ] File permissions correct
- [ ] .env file secure

### Functionality Checklist
- [ ] Homepage loading
- [ ] Admin login working
- [ ] Product catalog accessible
- [ ] Contact form functional
- [ ] WhatsApp integration working
- [ ] File upload working
- [ ] Database operations working

### Performance Checklist
- [ ] Assets cached
- [ ] Config cached
- [ ] Routes cached
- [ ] Views cached
- [ ] Images optimized
- [ ] Database indexed

### Monitoring Checklist
- [ ] Error logging enabled
- [ ] Backup strategy in place
- [ ] SSL certificate auto-renewal
- [ ] Performance monitoring
- [ ] Uptime monitoring

---

## 📞 SUPPORT

### InfinityFree Support
- **Website**: [infinityfree.net/support](https://infinityfree.net/support)
- **Forum**: [forum.infinityfree.net](https://forum.infinityfree.net)
- **Documentation**: [infinityfree.net/docs](https://infinityfree.net/docs)

### 000WebHost Support
- **Help Center**: [000webhost.com/help](https://000webhost.com/help)
- **Community**: [community.000webhost.com](https://community.000webhost.com)

### Laravel Support
- **Documentation**: [laravel.com/docs](https://laravel.com/docs)
- **Community**: [laracasts.com](https://laracasts.com)

---

## 🎉 SELAMAT!

Web Botani Anda sudah berhasil di-deploy ke hosting gratis!

**URL Website:** `https://botani.epizy.com` (InfinityFree)
**Admin Login:** 
- Email: `aufaajihadan@gmail.com`
- Password: `2200018304`

**Fitur yang Tersedia:**
- ✅ E-commerce (product catalog, cart, checkout)
- ✅ Eduwisata booking system
- ✅ WhatsApp notification
- ✅ Admin dashboard
- ✅ Content management
- ✅ File upload system

**Maintenance Tips:**
- Backup database secara regular
- Monitor error logs
- Update Laravel secara berkala
- Test fitur utama secara periodik

---

*Dokumen ini dibuat untuk panduan deployment web Botani ke hosting gratis. Update terakhir: Januari 2025* 