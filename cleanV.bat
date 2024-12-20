@echo off

del migrations\V*

symfony console doctrine:database:drop --force --no-interaction
symfony console doctrine:database:create

symfony console make:migration --no-interaction
symfony console doctrine:migrations:migrate --no-interaction

symfony console doctrine:fixtures:load