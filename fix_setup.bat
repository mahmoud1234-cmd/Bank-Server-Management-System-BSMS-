@echo off
echo Configuration de BSMS...

echo 1. Copie du fichier .env...
copy .env.example .env

echo 2. Installation des dependances Composer...
composer install --no-dev --optimize-autoloader

echo 3. Generation de la cle d'application...
php artisan key:generate --force

echo 4. Nettoyage du cache...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo 5. Configuration pour MySQL bank_servers...
echo Assurez-vous que XAMPP MySQL est demarré et que la base 'bank_servers' existe

echo 6. Execution des migrations...
php artisan migrate:fresh --seed --force

echo 7. Installation des dependances NPM...
npm install

echo 8. Compilation des assets...
npm run build

echo Configuration terminee!
echo Vous pouvez maintenant executer: php artisan serve
pause
