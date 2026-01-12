# 🚀 Commandes Utiles pour LuxeAuto

## Démarrage et Installation

### Installation Complète
```bash
# Installer tout et initialiser
composer install && npm install && php artisan key:generate && php artisan migrate && php artisan db:seed && npm run build
```

### Démarrer le Serveur
```bash
php artisan serve
```

### Démarrer avec Hot Reload (Développement)
```bash
npm run dev
```

---

## Gestion de la Base de Données

### Créer une Nouvelle Migration
```bash
php artisan make:migration create_table_name
```

### Exécuter les Migrations
```bash
php artisan migrate
```

### Annuler la Dernière Migration
```bash
php artisan migrate:rollback
```

### Annuler Toutes les Migrations
```bash
php artisan migrate:reset
```

### Refaire les Migrations avec Seed
```bash
php artisan migrate:refresh --seed
```

### Vider la Base de Données
```bash
php artisan db:wipe
```

### Remplir avec les Données de Test
```bash
php artisan db:seed
```

### Remplir une Table Spécifique
```bash
php artisan db:seed --class=DatabaseSeeder
```

---

## Gestion des Modèles et Contrôleurs

### Créer un Modèle
```bash
php artisan make:model NomModele
```

### Créer un Modèle avec Migration
```bash
php artisan make:model NomModele -m
```

### Créer un Contrôleur
```bash
php artisan make:controller NomController
```

### Créer un Contrôleur Ressource (CRUD)
```bash
php artisan make:controller NomController --resource
```

### Créer un Model Ressource complet
```bash
php artisan make:model NomModele --resource -m
```

---

## Artisan Tinker (Console Interactive)

### Accéder à Tinker
```bash
php artisan tinker
```

### Exemples dans Tinker

```php
// Créer une marque
$brand = Brand::create([
    'name' => 'Aston Martin',
    'slug' => 'aston-martin',
    'description' => 'Luxe britannique',
    'country' => 'Royaume-Uni',
    'year_founded' => 1913
]);

// Créer une voiture
$car = Car::create([
    'brand_id' => 1,
    'name' => 'Ferrari Testarossa',
    'slug' => 'ferrari-testarossa',
    'model' => 'Testarossa',
    'year' => 2023,
    'color' => 'Rouge',
    'price' => 350000,
    'fuel_type' => 'Essence',
    'transmission' => 'Automatique',
    'horsepower' => 550,
    'engine_displacement' => 4.9,
    'description' => 'Une icône automobile...',
    'is_available' => true,
    'is_featured' => true
]);

// Ajouter des équipements
$car->features()->create([
    'feature_name' => 'Toit Panoramique',
    'description' => 'Toit ouvrant électrique'
]);

// Lister toutes les voitures disponibles
Car::where('is_available', true)->get();

// Compter les voitures par marque
Brand::withCount('cars')->get();

// Trouver une voiture par slug
Car::where('slug', 'ferrari-f8-tributo')->first();

// Supprimer une voiture
$car = Car::find(1);
$car->delete();

// Mettre à jour une voiture
$car = Car::find(1);
$car->update(['price' => 400000]);
```

---

## Gestion du Cache

### Vider le Cache
```bash
php artisan cache:clear
```

### Vider la Config
```bash
php artisan config:clear
```

### Vider les Vues
```bash
php artisan view:clear
```

### Vider Tout le Cache
```bash
php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

---

## Compilation des Assets

### Build pour Production
```bash
npm run build
```

### Mode Développement avec Hot Reload
```bash
npm run dev
```

### Vérifier les Assets
```bash
npm run build -- --debug
```

---

## Routes et Tests

### Lister Toutes les Routes
```bash
php artisan route:list
```

### Lister les Routes avec Détails
```bash
php artisan route:list --verbose
```

### Lancer les Tests
```bash
php artisan test
```

### Tests avec Verbosité
```bash
php artisan test --verbose
```

---

## Optimisations

### Générer Auto-loader Optimisé
```bash
composer dump-autoload --optimize
```

### Optimiser l'Application
```bash
php artisan optimize
```

### Nettoyer l'Optimisation
```bash
php artisan optimize:clear
```

### Générer la Config en Cache
```bash
php artisan config:cache
```

### Générer les Routes en Cache
```bash
php artisan route:cache
```

---

## Maintenance

### Activer le Mode Maintenance
```bash
php artisan down
```

### Activer le Mode Maintenance avec Message
```bash
php artisan down --message="Maintenance en cours" --retry=60
```

### Désactiver le Mode Maintenance
```bash
php artisan up
```

### Générer une Nouvelle Clé APP
```bash
php artisan key:generate
```

### Vérifier l'Intégrité de l'Application
```bash
php artisan tinker
```

---

## Gestion de l'Authentification

### Générer l'Authentification Scaffolding (si nécessaire)
```bash
php artisan make:auth
```

### Créer un Utilisateur Admin
```bash
php artisan tinker
User::create([
    'name' => 'Admin',
    'email' => 'admin@luxeauto.fr',
    'password' => Hash::make('password'),
    'email_verified_at' => now()
]);
exit
```

---

## Erreurs Communes et Solutions

### Erreur: "No Application Encryption Key Specified"
```bash
php artisan key:generate
```

### Erreur: "Migration Not Found"
```bash
php artisan migrate:reset
php artisan migrate
```

### Erreur: "SQLSTATE[HY000] [2006]"
```bash
# Vérifier la connexion MySQL
# Vérifier les credentials dans .env
```

### Assets non Mis à Jour
```bash
npm run build
# Vider le cache du navigateur (Ctrl+Shift+Delete)
```

---

## Déploiement

### Préparation pour Production
```bash
# Copier le fichier .env
cp .env.example .env

# Générer la clé
php artisan key:generate

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Migrer la base de données
php artisan migrate --force

# Compiler les assets
npm run build

# Optimiser l'application
php artisan optimize
php artisan config:cache
php artisan route:cache
```

---

## Debugging

### Activer Debug Mode (dans .env)
```
APP_DEBUG=true
```

### Voir les Logs
```bash
tail -f storage/logs/laravel.log
```

### Utiliser dd() pour Debug
```php
dd($variable); // Dump and Die
dump($variable); // Dump only
```

---

## Commandes Personnalisées

### Créer une Commande Personnalisée
```bash
php artisan make:command NomCommande
```

### Exécuter une Commande Personnalisée
```bash
php artisan nom:commande
```

---

## Conseil de Productivité

### Alias Bash/Zsh (Ajout au .bashrc ou .zshrc)
```bash
alias artisan="php artisan"
alias tinker="php artisan tinker"
alias serve="php artisan serve"
alias migrate="php artisan migrate"
alias seed="php artisan db:seed"
alias test="php artisan test"
alias npm-dev="npm run dev"
alias npm-build="npm run build"
```

Après ajout:
```bash
source ~/.bashrc  # ou source ~/.zshrc
```

Utilisation:
```bash
artisan serve
tinker
migrate
```

---

## Ressources Utiles

- [Documentation Laravel](https://laravel.com/docs)
- [Documentation Blade](https://laravel.com/docs/blade)
- [Documentation Eloquent](https://laravel.com/docs/eloquent)
- [Documentation Tailwind CSS](https://tailwindcss.com/docs)
- [Artisan CLI](https://laravel.com/docs/artisan)

---

**Dernière mise à jour**: Janvier 2026
