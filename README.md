<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# PortManager project
PHP-Version: >= 8.0\
MySQL-Version: >= MariaDB 10.6.4\
GitHub: [https://github.com/berndengels/port](https://github.com/berndengels/port)  
Test URL: [https://port.segel-helden.de](https://port.segel-helden.de)

# Installation
- per terminal in your webroot directory  
git clone https://github.com/berndengels/port.git  
- cd harbor-manager
- copy .env.example to .env  
- set all credentials, tokens, passwords, urls in .env (DB, EMAIL)
- set app url in .env APP_URL / MIX_API_URL (use https)
- create MySql database 'port'
- unzip database/port-demo.sql.zip to database/port-demo.sql 
- import database/port-demo.sql file in port db

### For actual weather data:
Create a free account on openweathermap: [openweathermap](https://home.openweathermap.org/users/sign_up)\
generate a token on this API and put it in .env to "MIX_WEATHER_API_KEY"

### For mapbox satellite maps:
Create a free account for mapbox API: [mapbox](https://account.mapbox.com/auth/signup/)\
generate a token on this API and put it in .env to "MIX_MAPBOX_TOKEN"

### install php vendors and node_modules
in working directory run:
- composer install
- npm install
- npm run dev
- php artisan storage:link
- prepere your webserver: create virtual server host (https://port.test) **important: use https** 
- start http- and mysql-server
- open app-url in browser

### Admin Test Login:
  - route /admin
  - login: admin@test.loc
  - password: password

the default role for the admin demo test user is 'demonstration', he can only read data, but not change or create.
  - you can change the role to admin. go into the project folder per terminal and use that command:
  
  php artisan auth:set-admin-permission

### Customer Test Login:
- route /login
- login: kunde@test.loc
- password: password

