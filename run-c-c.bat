@echo off
setlocal

set "controller_name=%1"
if "%controller_name%"=="" (
    echo Ban chua nhap ten controller can tao !
    exit /b
)

php artisan make:controller %controller_name%

endlocal