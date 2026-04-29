# FleaMarket

# 環境構築

## Docker

git clone https://github.com/Naruyama628/FleaMarket.git  
cd FleaMarket

cp src/.env.example src/.env

.envにDB設定stripe mailtrapの設定を行う
.env にWebhook Secret反映

docker-compose up -d --build

###Laravel  
docker-compose exec php bash  
composer install  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
php artisan storage:link

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
