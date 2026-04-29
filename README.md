# FleaMarket

# 環境構築

## Docker

git clone https://github.com/Naruyama628/FleaMarket.git  
cd FleaMarket

cp src/.env.example src/.env

.envに環境変数を反映

docker-compose up -d --build

###Laravel  
docker-compose exec php bash  
composer install  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
php artisan storage:link

## 環境変数
STRIPE_KEY=xxxxxx
STRIPE_SECRET=xxxxxx
STRIPE_WEBHOOK_SECRET=xxxxxx

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxxxx
MAIL_PASSWORD=xxxxxx
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="${APP_NAME}"

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

# 使用技術

PHP 8.2.11

Laravel 8.83

MySQL 8.0.26

nginx 1.21.1

phpMyAdmin

Docker / Docker Compose

# ER図

![ER図](ER.png)

# URL

商品一覧画面: http://localhost/

ユーザー登録: http://localhost/register

phpMyAdmin: http://localhost:8080
