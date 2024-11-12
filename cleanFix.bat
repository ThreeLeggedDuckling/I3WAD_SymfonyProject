@echo off

symfony console doctrine:database:drop --force --no-interaction
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate --no-interaction
symfony console doctrine:fixtures:load --no-interaction