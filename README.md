Stock trader simulator \
Laravel\
Installation:\
composer install\
php artisan migrate\
php artisan db:seed --class=AdminMoneySeeder\
php artisan db:seed --class=StocksSeeder\
php artisan db:seed --class=StockHistoriesSeeder\
**Optional**:\
npm install\
npm rum prod\
**Add to crontab:**\
\* *     * * *   root    cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1


    


