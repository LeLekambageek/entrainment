#!/bin/bash

# Script d'initialisation du projet LuxeAuto
# Exécute les commandes de configuration initiale

echo ""
echo "========================================"
echo "  Initialisation du Projet LuxeAuto"
echo "========================================"
echo ""

# Vérifier si on est dans le bon répertoire
if [ ! -f "composer.json" ]; then
    echo "Erreur: Le fichier composer.json n'a pas été trouvé."
    echo "Veuillez exécuter ce script depuis la racine du projet."
    exit 1
fi

echo "[1/6] Installation des dépendances Composer..."
composer install || exit 1

echo ""
echo "[2/6] Installation des dépendances NPM..."
npm install || exit 1

echo ""
echo "[3/6] Génération de la clé APP..."
php artisan key:generate || exit 1

echo ""
echo "[4/6] Exécution des migrations..."
php artisan migrate || exit 1

echo ""
echo "[5/6] Remplissage de la base de données..."
php artisan db:seed || exit 1

echo ""
echo "[6/6] Compilation des assets..."
npm run build || exit 1

echo ""
echo "========================================"
echo "  Installation réussie!"
echo "========================================"
echo ""
echo "Vous pouvez maintenant démarrer le serveur avec:"
echo "  php artisan serve"
echo ""
echo "L'application sera accessible à:"
echo "  http://localhost:8000"
echo ""
