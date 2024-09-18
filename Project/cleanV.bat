@echo off

:Cleanmig
set /p choice=Clean the migrations folder? [y/n]
IF %choice% == n goto Newmig
del migrations\V*
symfony console doctrine:database:drop --force --no-interaction
symfony console doctrine:database:create

:Newmig
set /p choice=Make new migration? [y/n]
IF %choice% == n goto Fixtures
symfony console make:migration --no-interaction
symfony console doctrine:migrations:migrate --no-interaction

:Fixtures
set /p choice=Insert fixtures? [y/n]
IF %choice% == n exit
symfony console doctrine:fixtures:load --no-interaction