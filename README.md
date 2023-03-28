<p align="center">Step by step menjalankan projek ini</p>
<ul>
    <li>PHP 8.0</li>
    <li>Laravel 9.19</li>
</ul>
<p>projek ini menggunakan vite / asset bundler yg lebih modern dibanding webpack (Mix), maka harus melakukan ini setelah clone : https://github.com/laravel/vite-plugin/blob/main/UPGRADE.md#migrating-from-laravel-mix-to-vite</p>
<br>
    <ul>
        <li>clone terlebih dahulu</li>
        <li>lakukan perintah diatas</li>
        <li>buat folder captcha di dalam storage/app/public</li>
        <li>run php artisan storage:link</li>
        <li>run : npm install , lalu npm run dev (jangan ditutup terminalnya)</li>
        <li>run : php artisan migrate --path=database/migrations/survey , lalu php artisan serve</li>
    </ul>

<p align="center">Selamat Mencoba !!!</p>