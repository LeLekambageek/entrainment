# LuxeAuto - Plateforme de Vente de Voitures de Luxe

Une plateforme web premium pour la vente et la mise en valeur de voitures de luxe exceptionnelles. Construite avec Laravel et Tailwind CSS.

## Caractéristiques

✨ **Design Luxe**
- Interface élégante et moderne
- Mode sombre intégré
- Animations sophistiquées
- Responsive design

🚗 **Catalogue de Voitures**
- Affichage détaillé des véhicules
- Galerie d'images
- Spécifications techniques complètes
- Équipements et features

🔍 **Système de Recherche Avancée**
- Filtrage par marque
- Filtrage par carburant
- Filtrage par transmission
- Filtrage par prix

💬 **Système de Renseignements**
- Formulaire de contact pour chaque voiture
- Collecte de données leads
- Gestion des demandes

📊 **Dashboard**
- Gestion des voitures
- Gestion des marques
- Suivi des demandes

## Installation

### Prérequis

- PHP >= 8.2
- Composer
- Node.js et npm
- MySQL ou SQLite

### Étapes d'installation

1. **Cloner le repository**
```bash
cd c:\xampp\htdocs\entrainment
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances Node.js**
```bash
npm install
```

4. **Créer le fichier .env**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurer la base de données**

Éditer le fichier `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=luxeauto
DB_USERNAME=root
DB_PASSWORD=
```

6. **Créer la base de données**
```bash
mysql -u root -e "CREATE DATABASE luxeauto;"
```

7. **Exécuter les migrations**
```bash
php artisan migrate
```

8. **Remplir la base de données avec des données de test**
```bash
php artisan db:seed
```

9. **Compiler les assets**
```bash
npm run build
```

Ou en mode développement avec watch:
```bash
npm run dev
```

10. **Démarrer le serveur**
```bash
php artisan serve
```

L'application sera accessible à `http://localhost:8000`

## Structure du Projet

```
app/
├── Http/Controllers/
│   ├── CarController.php       # Gestion des voitures
│   └── InquiryController.php   # Gestion des demandes
├── Models/
│   ├── Car.php                 # Modèle Voiture
│   ├── Brand.php               # Modèle Marque
│   ├── CarImage.php            # Modèle Images de voitures
│   ├── CarFeature.php          # Modèle Équipements
│   └── Inquiry.php             # Modèle Demandes
└── ...

database/
├── migrations/                 # Schéma de base de données
└── seeders/                    # Données de test

resources/
├── views/
│   ├── layouts/app.blade.php   # Layout principal
│   └── cars/
│       ├── index.blade.php     # Page d'accueil
│       ├── show.blade.php      # Détail d'une voiture
│       └── search.blade.php    # Page de recherche
└── css/
    └── app.css                 # Styles Tailwind

routes/
└── web.php                     # Routes publiques
```

## Routes Disponibles

| Route | Description |
|-------|-------------|
| `/` | Page d'accueil |
| `/voitures` | Catalogue complet |
| `/voitures/{slug}` | Détail d'une voiture |
| `/search` | Recherche avancée |
| `POST /inquiry` | Soumettre une demande |

## Utilisation

### Ajouter une Nouvelle Voiture

1. Créer une nouvelle marque (via base de données ou admin)
2. Créer la voiture avec ses détails
3. Ajouter des images
4. Ajouter des équipements
5. Marquer comme disponible

### Modèles de Données

**Car (Voiture)**
- Marque
- Modèle et année
- Prix
- Spécifications (carburant, transmission, puissance, etc.)
- Description
- Disponibilité
- Images et équipements

**Brand (Marque)**
- Nom
- Description
- Logo
- Pays d'origine
- Année de fondation

**Inquiry (Demande)**
- Contact du client
- Voiture intéressée
- Message
- Statut (pending, contacted, completed)

## Développement

### Ajouter de nouvelles routes
Éditer `routes/web.php`

### Créer un nouveau contrôleur
```bash
php artisan make:controller NouveauController
```

### Créer une nouvelle migration
```bash
php artisan make:migration nom_migration
```

### Créer un nouveau modèle
```bash
php artisan make:model NouveauModele
```

## Technologies Utilisées

- **Framework**: Laravel 11
- **Frontend**: Tailwind CSS, Alpine.js
- **Base de données**: MySQL/SQLite
- **Build Tool**: Vite
- **Fonts**: Google Fonts (Playfair Display, Inter)

## Maintenance

### Nettoyer le cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Générer un nouveau APP_KEY
```bash
php artisan key:generate
```

## Support et Améliorations Futures

Améliorations potentielles:
- Authentification admin
- Dashboard d'administration complet
- Upload de photos
- Système de comparaison de voitures
- Système de favoris
- Historique des consultations
- Intégration paiement
- Notifications email
- Système de reviews/avis

## License

MIT

## Contact

Pour toute question ou demande:
- Email: contact@luxeauto.fr
- Tél: +33 1 23 45 67 89
