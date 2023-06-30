
set -e
echo "Deploying application"

#Enter maintenance mode

(php artisan down --message 'The website is been quickly updated. Please try again in minutes.') || true
  #update codebase
  git fetch --all
  git reset --hard origin/development

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
