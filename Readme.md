composer install  
php artisan storage:link  
add to cron '* * * * * cd /home/hiro/MoscowObjects && php artisan schedule:run >> /dev/null 2>&1'  
php artisan currencies:refresh  
