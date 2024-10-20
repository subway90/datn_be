@echo off
setlocal

set "migration_name=%1"
if "%migration_name%"=="" (
    echo Ban chua nhap ten migrate can tao !
    exit /b
)

php artisan make:migration create_%migration_name%_table --create=%migration_name%

endlocal