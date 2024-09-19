@echo off

:CleanV
set /p choice=Clean the migrations folder? [y/n]
IF %choice% == n goto Rebuild
del migrations\V*

:Rebuild
set /p choice=Rebuild DB? [y/n]
IF %choice% == n goto NewM
symfony console doctrine:database:drop --force --no-interaction
symfony console doctrine:database:create

:NewM
set /p choice=Make new migration? [y/n]
IF %choice% == n goto Fixtures
symfony console make:migration --no-interaction
symfony console doctrine:migrations:migrate --no-interaction

:Fixtures
set /p choice=Insert fixtures? [y/n]
IF %choice% == n exit
symfony console doctrine:fixtures:load --no-interaction