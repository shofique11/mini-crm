## Requirement stack
<p>php apache server, Mysql database, Composer<p>

## clone the github link
```
git clone https://github.com/shofique11/mini-crm.git
```
## install the dependency
```
 composer install
```
## config .env file

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
JWT_SECRET=
```

## Migrate the schema file

```
php artisan migrate

```
## JWT Secreet key
```
php artisan jwt:secret
```
## DB seed for 1 admin and 4 counselor
```
php artisan db:seed
```

## Run the project
```
php artisan serve
```
## If any cahec, clear
```
php artisan cache:clear
php artisan config:cache
php artisan route:clear
php artisan optimize:clear
```
