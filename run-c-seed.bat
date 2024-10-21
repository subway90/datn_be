@echo off
setlocal

set "seed_name=%1"
if "%seed_name%"=="" (
    echo Ban chua nhap ten seeder can tao !
    exit /b
)

php artisan make:seeder %seed_name%Seeder

endlocal