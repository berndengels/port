<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# PortManager project
PHP-Version: 8.0\
MySQL-Version: MariaDB 10.6.4\
Test URL: [https://port.segel-helden.de](https://port.segel-helden.de)

- copy .env.example to .env  
- set all credentials, tokens, passwords, urls in .env (DB, EMAIL)
- set app url in .env APP_URL/MIX_API_URL (use https)
- create MySql database 'port'
- import port.sql file in port db

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
- start http- and mysql-server
- open app-url in browser

### Admin Test Login:
  - route /admin
  - login: admin@test.loc
  - password: password

### Customer Test Login:
- route /login
- login: kunde@test.loc
- password: password
