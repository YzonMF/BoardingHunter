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
- Role-based access: Admin, Room Owner, Room Seeker (public sign-up is limited to owner and seeker)
- Room browsing with search and filters, room details with photos, amenities and reviews
- **Inquiries:** seekers message a room's owner; the owner replies
- **Reservations:** a seeker asks for a hold; the owner approves it and the room is held for **7 days from approval**, then released automatically if not booked
- **Bookings:** book from an approved reservation, or book directly (the owner accepts or rejects); the room status updates (reserved / booked)
- **Reviews:** seekers rate rooms they have a confirmed booking for
- **Notifications:** in-app notifications for inquiries, replies, reservation/booking requests and decisions, expiries and reviews
- **Owner tools:** create/edit/delete listings, upload photos, manage amenities
- **Community board:** read publicly, post when signed in, admins moderate
- **Profile:** edit details and change password
- **Admin:** dashboard, user management, listing moderation, reports and site settings
- **Site settings (database-driven):** site name, contact email/phone/address, About text, currency symbol and the reservation hold length are stored in the `settings` table and edited by admins at *Admin > Settings*; nothing like that is hard-coded in the views
- **Password reset:** "Forgot password?" emails a reset link (single use, rate limited)

## Tech Stack

- **Backend:** Laravel 12.x (PHP 8.2+)
- **Database:** MySQL
- **Frontend:** Blade Templates + Bootstrap 5
- **Dev Server:** Laragon

## Getting Started

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database
4. Run `php artisan key:generate`
5. Run `php artisan migrate --seed` (creates the tables and demo data)
6. Run `php artisan storage:link` (needed so uploaded listing photos are served)
7. Run `php artisan serve`

### Email (password reset)

`.env.example` uses `MAIL_MAILER=log`, so reset emails are written to `storage/logs/laravel.log` instead of being sent. Open the log and copy the reset link. Configure a real mailer (`MAIL_MAILER=smtp` plus host/credentials) when you deploy.

### Demo accounts

`php artisan migrate:fresh --seed` resets the database to this demo data. Every account uses the password `password`.

| Role | Email |
|---|---|
| Admin | admin@boardinghunter.test |
| Room Owner | owner@boardinghunter.test, owner2@boardinghunter.test |
| Room Seeker | seeker@boardinghunter.test, seeker2@boardinghunter.test |

### Scheduled task

Approved reservations expire 7 days after approval. The `reservations:expire` command (hourly) releases them and notifies both sides. Run the scheduler locally with `php artisan schedule:work`, or add a cron entry for `php artisan schedule:run` in production. Expired holds are also released whenever the affected pages are loaded, so rooms are never locked if the scheduler is not running.

## Sequence diagram

`resources/sequence.jpg` is the original design (seeker flow: sign in, browse, contact owner, reserve/book with owner approval, log out).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
