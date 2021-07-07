
# Laravel+Vue Crud Starter

## Tech Specification

- Laravel 8
- Vue 2 + VueRouter + vue-progressbar + sweetalert2 + laravel-vue-pagination
- Laravel Passport
- Admin LTE 3 + Bootstrap 4 + Font Awesome 5
- PHPUnit Test Case/Test Coverage

## Features

- Modal based Create+Edit, List with Pagination, Delete with Sweetalert
- Login, Register, Forget+Reset Password as default auth
- Profile, Update Profile, Change Password, Avatar
- Developer Management 
- User Management
- Settings: Categories, Tags
- Frontend and Backend User ACL with Gate Policy (type: admin/user)
- Simple Static Dashboard
- Build with Docker

## Installation

- `git clone https://github.com/pugal7/posable.git`
- `cd posable/`
- cp .env.example .env
- Update `.env` and set your database credentials
- update `.env` and set your smtp credentials if email needed
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- `npm install`
- `npm run dev`
- `php artisan serve`

## Install with Docker

- `docker-compose up -d`
- `docker exec -it vue-starter /bin/bash`
- `composer install`
- `cp .env.example .env`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- Application http://localhost:8008/
- Adminer for Database http://localhost:8080/
- DBhost: yourIP:3307, user: root, Password: 123456

## License

[MIT license](https://opensource.org/licenses/MIT).
"# posable" 
"# posable" 
