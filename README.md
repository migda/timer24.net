# timer24.net
**Countdown Timer PHP Web Application created in Laravel 5.3.**

##Libraries and frameworks I used in this project:
- Laravel 5.3.11,
- jQuery 1.12.4, jQuery UI 1.12.0
- Bootstrap 3.3.7, Bootswatch (Flatly, Yeti), Bootstrap DatetimePicker 4.17.4
- Moment.js 2.15.1,
- Moment Timezone 0.5.6

###Instalation
- cmd: cp .env.example .env (copy .env.example  file  and rename it to .env)
- modify .env and set up db connection
- cmd: php artisan key:generate
- cmd: php artisan migrate
- browser: register user via register form
- db query: access to admin panel: UPDATE users SET role = 2 WHERE id = *user id*;

###Demo: http://timer24.net/