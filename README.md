<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Project
Web application e-commerce jual beli sayur adalah platform digital yang memungkinkan konsumen untuk membeli sayur secara online dengan mudah dan efisien. Sistem ini mendukung dua jenis pengguna, yaitu adminToko (penjual) dan konsumen (pembeli). AdminToko dapat mengelola produk, pesanan, dan melihat statistik penjualan melalui dashboard. Konsumen dapat mencari produk, menambahkan ke keranjang, dan melakukan pembayaran secara online. Untuk metode pembayaran, sistem terintegrasi dengan Midtrans untuk memastikan proses transaksi yang aman dan terpercaya. Platform ini bertujuan untuk mempermudah akses masyarakat ke kebutuhan sayur segar dengan cara modern.


## Developer

<a href="https://github.com/surinanda99">Surinanda</a>
<a href="https://github.com/Hypes-Astro">Alif Anwar</a>

## Setup
1. composer install
2. npm install
3. php artisan migrate
4. .env dirubah ya, copy aja dari .env.example
5. php artisan jwt:secret
6. php artisan serve
---
## Khusus Env (line 11 untuk setting DB)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sayurin-api
DB_USERNAME=root
DB_PASSWORD=
