composer install --no-ansi --no-dev --no-interaction --no-progress --no-scripts --optimize-autoloader

rm -rf vendor/psr/container

composer dump-autoload -o
