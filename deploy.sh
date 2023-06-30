
set -e
echo "Deploying application"

#Enter maintenance mode

(php artisan down --message 'The website is been quickly updated. Please tey again in minutes.') || true
  #update codebase
  git add .
  git commit -m 'stashing and commiting before deploying'
  git pull origin master

#exit maintainance mode
composer install
php artisan config:clear
php artisan cache:clear
composer dump-autoload
php artisan view:clear
php artisan route:clear
php artisan migrate --force
php artisan optimize
php artisan up

echo "Website deployed"
