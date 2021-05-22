Latihan projek Laravel membuat sistem toko buku

## Requirement
- PHP >=7.3
- Laravel 7
- MySQL
- Composer
- NPM

## Instalasi
1. Clone repository ini
2. Copy env.example jadi .env, sesuaikan dengan database yang digunakan
3. Jalankan ``php artisan key:generate``
4. Jalankan ``composer install``
5. Jalankan ``php artisan migrate`` untuk menghasilkan struktur database
6. Jalankan ``php artisan db:seed`` untuk menghasilkan user-user yang bisa digunakan untuk login. Secara default, seluruh password untuk login adalah ``password``
7. Akses menggunakan XAMPP dengan localhost/direktori_tempat_repo_ini

## Ke Depannya
Membuat API kemudian menghubungkannya ke project Vue yang ada di repo ini https://github.com/ahadimuhsin/vueshop.git
