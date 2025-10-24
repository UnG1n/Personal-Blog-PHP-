@echo off
echo Запуск сервера блога...
echo Откройте http://localhost:8000 в браузере
echo Для остановки нажмите Ctrl+C
echo.
C:\tools\php84\php.exe -S localhost:8000 -t public
pause
