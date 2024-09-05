@echo off

echo Deleting previous versions files ...
del migrations\V*
echo Previous versions files deleted

echo Dropping previous database ...
symfony console doctrine:database:drop --force --no-interaction

echo Creating new database ...
symfony console doctrine:database:create

echo Generating new version file ...
symfony console make:migration --no-interaction

echo Migrating new migration ...
symfony console doctrine:migrations:migrate --no-interaction