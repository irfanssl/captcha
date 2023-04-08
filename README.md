<p align="center">Step by step menjalankan projek ini</p>
<ul>
    <li>PHP 8.0</li>
    <li>Laravel 9.19</li>
</ul>
<p>Lakukan perintah ini : projek ini menggunakan vite / asset bundler yg lebih modern dibanding webpack (Mix), maka harus melakukan ini setelah clone : https://github.com/laravel/vite-plugin/blob/main/UPGRADE.md#migrating-from-laravel-mix-to-vite</p>
<br>
    <ul>
        <li>clone terlebih dahulu</li>
        <li>buat file .env seperti biasa, lalu sesuaikan koneksi databasenya</li>
        <li>lakukan perintah diatas</li>
        <li>buat folder captcha di dalam storage/app/public</li>
        <li>run php artisan storage:link</li>
        <li>run composer install</li>
        <li>run npm install</li>
        <li>run npm run dev</li>
        <li>run npm run build</li>
        <li>run hp artisan migrate --path=database/migrations/survey</li>
        <li>run php artisan serve</li>
        <li>upss kelupaan, library gregwar/captcha membutuhkan gd extension, silakan dinyalakan dulu di php.ini, cari extension=gd hilangkan ; lalu save</li>
    </ul>

<p align="center">Selamat Mencoba !!!</p>