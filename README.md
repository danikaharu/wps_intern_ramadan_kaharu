## Spesifikasi 
1. Minimal PHP versi 8.2
2. Sudah terinstall Git dan Composer 

## Tutorial Instalasi

1. Jalankan perintah git clone https://github.com/danikaharu/wps_intern_ramadan_kaharu.git di terminal
2. Jalankan perintah composer install di terminal
3. Jalankan perintah cp .env.example .env
4. Kembali ke terminal, php artisan key:generate.
5. Setting koneksi database di file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
6. Jalankan perintah php artisan migrate Jika di cek di phpmyadmin, seharusnya tabel sudah muncul.
7. Jalankan perintah php artisan db:seed untuk membuat pengguna
8. Terakhir jalankan perintah php artisan serve

## Akun Demo
email    : direktur@gmail.com
password : 123456

