@echo off
REM Script d'initialisation du projet LuxeAuto
REM Exécute les commandes de configuration initiale

echo.
echo ========================================
echo   Initialisation du Projet LuxeAuto
echo ========================================
echo.

REM Vérifier si on est dans le bon répertoire
if not exist "composer.json" (
    echo Erreur: Le fichier composer.json n'a pas été trouvé.
    echo Veuillez exécuter ce script depuis la racine du projet.
    pause
    exit /b 1
)

echo [1/6] Installation des dépendances Composer...
call composer install
if errorlevel 1 (
    echo Erreur lors de l'installation de Composer.
    pause
    exit /b 1
)

echo.
echo [2/6] Installation des dépendances NPM...
call npm install
if errorlevel 1 (
    echo Erreur lors de l'installation de NPM.
    pause
    exit /b 1
)

echo.
echo [3/6] Génération de la clé APP...
call php artisan key:generate
if errorlevel 1 (
    echo Erreur lors de la génération de la clé.
    pause
    exit /b 1
)

echo.
echo [4/6] Exécution des migrations...
call php artisan migrate
if errorlevel 1 (
    echo Erreur lors des migrations.
    pause
    exit /b 1
)

echo.
echo [5/6] Remplissage de la base de données...
call php artisan db:seed
if errorlevel 1 (
    echo Erreur lors du seed.
    pause
    exit /b 1
)

echo.
echo [6/6] Compilation des assets...
call npm run build
if errorlevel 1 (
    echo Erreur lors de la compilation des assets.
    pause
    exit /b 1
)

echo.
echo ========================================
echo   Installation réussie!
echo ========================================
echo.
echo Vous pouvez maintenant démarrer le serveur avec:
echo   php artisan serve
echo.
echo L'application sera accessible à:
echo   http://localhost:8000
echo.
pause
