@echo off
setlocal

set "model_name=%1"
if "%model_name%"=="" (
    echo Ban chua nhap ten model can tao !
    exit /b
)

php artisan make:model %model_name%Model

endlocal