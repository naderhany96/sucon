# Sucon App

Application for Therapists.

## Tech Stack

**Client:** [Vue 2](https://v2.vuejs.org/ "Vue 2 Homepage"), [BootstrapVue](https://bootstrap-vue.org/ "BootstrapVue Homepage"), [Nazox Theme](https://themesdesign.in/nazox/layouts/index.html/ "Nazox Dashboard")

**Server:** [Laravel 9](https://laravel.com/ "Laravel Homepage")

Requirements
------------
 - PHP 8.1.9+
 - Composer 2.4.1+
 - Laravel 9.0+
 - Vue 2.0 <-
 - Node 14.21.0 <- You may need [NVM](https://github.com/nvm-sh/nvm "NVM Github") for this. 

## Installation

Clone the project

```bash
git clone https://github.com/josequalgit/medical_web.git
```

Go to the project directory

```bash
cd medical_web
```

Install PHP dependencies

```bash
composer install
```

Copy env file

```bash
cp .env.example .env
```

Add migrations and seeders

```bash
php artisan migrate --seed
```

Start the server and open the link http://127.0.0.1:8000

```bash
php artisan serve
```

You need to add this to php.ini

``` bash
upload_max_filesize = 100M
post_max_size = 100M
```

For production only add this to PHP 8+ php.ini file
``` bash
opcache.enable=1
opcache.memory_consumption=512
opcache.interned_strings_buffer=64
opcache.max_accelerated_files=32531
opcache.validate_timestamps=0
opcache.save_comments=1
```

## TODO

1- Activate the scheduled jobs on the server

```bash
/public_html/artisan schedule:run >> /dev/null 2>&1
```