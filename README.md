# FleaMarket

# 環境構築

## Docker

git clone https://github.com/Naruyama628/FleaMarket.git  
cd FleaMarket  
docker-compose up -d --build

###Laravel  
docker-compose exec php bash  
composer install  
cp .env.example .env  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
php artisan storage:link  
※ .env のDB設定は docker-compose.yml に合わせてください。

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
# FleaMarket

# 環境構築

## Docker

git clone https://github.com/Naruyama628/FleaMarket.git  
cd FleaMarket  
docker-compose up -d --build

###Laravel  
docker-compose exec php bash  
composer install  
cp .env.example .env  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
php artisan storage:link  
※ .env のDB設定は docker-compose.yml に合わせてください。

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
# FleaMarket

# 環境構築

## Docker

git clone https://github.com/Naruyama628/FleaMarket.git  
cd FleaMarket  
docker-compose up -d --build

###Laravel  
docker-compose exec php bash  
composer install  
cp .env.example .env  
php artisan key:generate  
php artisan migrate  
php artisan db:seed  
php artisan storage:link  
※ .env のDB設定は docker-compose.yml に合わせてください。

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
