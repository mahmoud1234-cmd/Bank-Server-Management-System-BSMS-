@echo off
echo ========================================
echo    REINSTALLATION COMPLETE BSMS
echo ========================================

echo 1. Suppression des caches et fichiers temporaires...
if exist "bootstrap\cache\*.php" del /q "bootstrap\cache\*.php"
if exist "storage\framework\cache\*" del /q /s "storage\framework\cache\*"
if exist "storage\framework\sessions\*" del /q /s "storage\framework\sessions\*"
if exist "storage\framework\views\*" del /q /s "storage\framework\views\*"
if exist "storage\logs\laravel.log" del /q "storage\logs\laravel.log"

echo 2. Reinstallation des dependances Composer...
composer clear-cache
composer install --optimize-autoloader --no-dev

echo 3. Configuration de l'environnement...
copy .env.example .env
php artisan key:generate --force

echo 4. Nettoyage complet Laravel...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

echo 5. Configuration MySQL pour XAMPP...
echo IMPORTANT: Assurez-vous que MySQL est demarré dans XAMPP
echo et que la base de donnees 'bank_servers' existe
pause

echo 6. Creation des tables et donnees de test...
php artisan migrate:fresh --seed --force

echo 7. Installation des dependances NPM...
npm cache clean --force
npm install

echo 8. Compilation des assets frontend...
npm run build

echo 9. Optimisation pour production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ========================================
echo    INSTALLATION TERMINEE !
echo ========================================
echo.
echo Demarrez le serveur avec: php artisan serve
echo Puis allez sur: http://127.0.0.1:8000
echo.
echo Comptes de test:
echo - admin@banque.fr / password
echo - tech.senior@banque.fr / password
echo.
pause
