# Install
## 1 - composer update
### composer dump-autoload
## 2 - migrate datebase
### php artisan migrate 
### php artisan db:seed
### php artisan migrate:fresh --seed
## 3 - Generate migration from database
### php artisan ybr:gen-migrations
## 4 - Generate Models and CRUD from tablename
### php artisan ybr:gen-crud {tablename} {--force}
# Preview
![preview](preview.png)


