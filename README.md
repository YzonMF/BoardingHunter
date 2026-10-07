<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About BoardingHunter

BoardingHunter is a web application for finding and managing boarding accommodations. It connects Room Owners who list their properties with Room Seekers who search for places to stay.

### Features
- User registration with role-based access (Admin, Room Owner, Room Seeker)
- Accommodation listings with search and filters
- Admin dashboard for user management
- Photo galleries for accommodations
- Inquiry system between seekers and owners

## Tech Stack

- **Backend:** Laravel 10.x (PHP 8.1+)
- **Database:** MySQL
- **Frontend:** Blade Templates + Bootstrap 5
- **Dev Server:** Laragon

## Getting Started

1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env` and configure your database
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Run `php artisan serve`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
