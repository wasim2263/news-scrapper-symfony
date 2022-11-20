# news-scrapper-symfony
# php bin/console doctrine:fixtures:load
php bin/console doctrine:schema:update --force
php bin/console messenger:consume async -vv
