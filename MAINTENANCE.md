# 🎓 Guide de Maintenance et Bonnes Pratiques

## Table des Matières
1. [Maintenance Régulière](#maintenance-régulière)
2. [Sécurité](#sécurité)
3. [Performance](#performance)
4. [Bonnes Pratiques](#bonnes-pratiques)
5. [Troubleshooting](#troubleshooting)

---

## Maintenance Régulière

### Quotidienne
```bash
# Vérifier les logs
tail -f storage/logs/laravel.log

# Surveiller les demandes
php artisan tinker
Inquiry::where('status', 'pending')->count()
```

### Hebdomadaire
```bash
# Vider le cache
php artisan cache:clear

# Vérifier la santé de l'application
php artisan tinker
# Tester quelques requêtes
Car::where('is_available', true)->count()
Brand::count()
```

### Mensuelle
```bash
# Optimiser la base de données
php artisan optimize

# Vérifier l'intégrité des relations
php artisan tinker
Car::with('brand')->where('brand_id', null)->count()

# Archiver les inquiries anciennes (optionnel)
Inquiry::where('updated_at', '<', now()->subMonths(6))->delete()
```

### Annuellement
```bash
# Backup complet
mysqldump -u root luxeauto > backup_$(date +%Y%m%d).sql

# Mise à jour des dépendances
composer update
npm update

# Audit de sécurité
composer audit
npm audit fix
```

---

## Sécurité

### Fichier .env
⚠️ **TOUJOURS garder .env hors du repository**

```bash
# Vérifier que .gitignore contient:
.env
.env.local
.env.*.local
storage/logs/*
```

### Variables d'Environnement Sécurisées
```env
# Développement
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://luxeauto.fr

# Sécurité
CSRF_ENABLED=true
SESSION_SECURE_COOKIES=true (en HTTPS)
SESSION_HTTP_ONLY=true
```

### Protection des Routes
Pour protéger les routes sensibles:

```php
// routes/web.php
Route::post('/inquiry', [InquiryController::class, 'store'])->middleware('throttle:6,1');
```

### Validation des Données
```php
// Toujours valider les inputs
$validated = request()->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email',
    'phone' => 'required|string|max:20|regex:/^[0-9+\s\-()]+$/',
    'message' => 'nullable|string|max:1000'
]);
```

---

## Performance

### Optimisation des Requêtes

#### Lazy Loading (À ÉVITER)
```php
// ❌ Mauvais: N+1 queries
$cars = Car::all();
foreach ($cars as $car) {
    echo $car->brand->name; // Requête pour chaque voiture!
}
```

#### Eager Loading (À PRÉFÉRER)
```php
// ✅ Bon: 2 requêtes
$cars = Car::with('brand')->get();
foreach ($cars as $car) {
    echo $car->brand->name; // Pas de requête supplémentaire
}
```

#### Autres Exemples
```php
// Multiple relations
$cars = Car::with(['brand', 'images', 'features'])->get();

// Nested relations
$cars = Car::with('brand.country')->get();

// Conditional eager loading
$cars = Car::with('images', function($query) {
    $query->limit(3);
})->get();
```

### Pagination
```php
// ✅ Toujours paginer les listes
$cars = Car::paginate(12); // 12 par page

// Dans la vue
{{ $cars->links() }}
```

### Cache
```php
// Cacher les résultats chers
use Illuminate\Support\Facades\Cache;

$brands = Cache::remember('brands', 3600, function() {
    return Brand::withCount('cars')->get();
});
```

### Indexer la Base de Données
```sql
-- Ajouter des index aux migrations
Schema::table('cars', function (Blueprint $table) {
    $table->index('brand_id');
    $table->index('slug');
    $table->index('is_available');
    $table->fullText('name', 'description'); // pour la recherche
});
```

---

## Bonnes Pratiques

### Nommage
```php
// ✅ Bon
public function getFeaturedCars()
private function validateCarData()

// ❌ Mauvais
public function getFeaturedCarss() // Typo
private function check() // Trop vague
```

### Commentaires
```php
// ❌ Commentaires inutiles
$car = Car::find($id); // Trouver la voiture

// ✅ Commentaires utiles
// Récupérer la voiture avec ses relations pour éviter N+1 queries
$car = Car::with(['brand', 'images'])->find($id);
```

### Structure du Code
```php
// ✅ Bon - Logique claire
public function search()
{
    $query = Car::where('is_available', true);
    
    if (request('brand')) {
        $query->whereHas('brand', function($q) {
            $q->where('slug', request('brand'));
        });
    }
    
    return $query->paginate(12);
}
```

### Gestion des Erreurs
```php
// ✅ Toujours gérer les erreurs
try {
    $car = Car::findOrFail($id);
} catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    return back()->with('error', 'Voiture non trouvée');
}

// Ou utiliser firstOrFail
$car = Car::where('slug', $slug)->firstOrFail();
```

### Transactions pour les Opérations Critiques
```php
use Illuminate\Support\Facades\DB;

// ✅ Atomicité garantie
DB::transaction(function() {
    $car = Car::create([...]);
    $car->images()->create([...]);
    $car->features()->create([...]);
});
```

---

## Troubleshooting

### Problème: "SQLSTATE[28000] [1045] Access Denied"
```bash
# Solution: Vérifier les credentials .env
# Corriger DB_HOST, DB_USERNAME, DB_PASSWORD
php artisan config:clear
```

### Problème: Migration échoue
```bash
# Solution 1: Rollback et retry
php artisan migrate:rollback
php artisan migrate

# Solution 2: Reset complet
php artisan migrate:reset
php artisan migrate --seed
```

### Problème: Assets non trouvés (CSS/JS vides)
```bash
# Solution: Recompiler les assets
npm run build

# En développement avec hot reload:
npm run dev
```

### Problème: Enquiries non sauvegardées
```php
// Debug dans Tinker
php artisan tinker
Inquiry::count() // Vérifier le nombre

// Vérifier les erreurs de validation
$validated = request()->validate([...]);
// Vérifier les messages d'erreur dans la session
```

### Problème: Images ne s'affichent pas
```bash
# Créer le lien symbolique
php artisan storage:link

# Vérifier le chemin de l'image
ls -la storage/app/public/
```

### Problème: Problèmes de Permissions
```bash
# Donner les permissions correctes
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### Problème: Slugs en doublon
```php
// Ajouter une validation d'unicité
Schema::table('cars', function (Blueprint $table) {
    $table->unique('slug'); // Ajouter cette contrainte
});
```

---

## Checklist de Production

Avant de déployer en production:

- [ ] `APP_DEBUG=false` dans .env
- [ ] `APP_ENV=production` dans .env
- [ ] Certificat SSL/HTTPS installé
- [ ] Base de données sauvegardée
- [ ] Assets compilés (`npm run build`)
- [ ] Cache configuré correctement
- [ ] Logs configurés (rotation, niveau)
- [ ] Session sécurisée (HTTPS, HttpOnly)
- [ ] CSRF protection activée
- [ ] Rate limiting sur les formulaires
- [ ] Monitoring mis en place
- [ ] Backup automatisé configuré
- [ ] Email configuré pour notifications
- [ ] Tests passants (`php artisan test`)

---

## Monitoring en Production

### Logs
```bash
# Vérifier les erreurs
grep "ERROR" storage/logs/laravel.log | tail -20

# Monitoring continu
tail -f storage/logs/laravel.log
```

### Performance
```bash
# Requêtes lentes
php artisan tinker
DB::enableQueryLog();
Car::with('brand')->get();
dd(DB::getQueryLog());
```

### Santé de l'Appplication
```bash
# Health check endpoint (optionnel à créer)
Route::get('/health', function() {
    return response()->json(['status' => 'ok']);
});
```

---

## Mise à Jour des Dépendances

```bash
# Vérifier les mises à jour disponibles
composer outdated
npm outdated

# Mettre à jour en toute sécurité
composer update
npm update

# Vérifier les vulnérabilités
composer audit
npm audit

# Corriger les vulnérabilités connues
npm audit fix
composer audit --fix
```

---

## Backup et Récupération

### Backup Manuel
```bash
# Base de données
mysqldump -u root -p luxeauto > backup_$(date +%Y%m%d_%H%M%S).sql

# Fichiers (images, documents)
tar -czf files_backup_$(date +%Y%m%d).tar.gz storage/app/public/

# Code source
tar -czf code_backup_$(date +%Y%m%d).tar.gz --exclude=storage --exclude=vendor --exclude=node_modules .
```

### Restauration
```bash
# Base de données
mysql -u root -p luxeauto < backup_20260112_120000.sql

# Extraire les fichiers
tar -xzf files_backup_20260112.tar.gz
```

### Backup Automatisé (Cron)
```bash
# Ajouter au crontab
0 2 * * * mysqldump -u root -p luxeauto > /backups/luxeauto_$(date +\%Y\%m\%d).sql
0 3 * * * tar -czf /backups/files_$(date +\%Y\%m\%d).tar.gz /var/www/luxeauto/storage
```

---

## Support et Ressources

- 📚 [Documentation Laravel](https://laravel.com/docs)
- 📖 [Documentation Eloquent](https://laravel.com/docs/eloquent)
- 🎨 [Documentation Tailwind](https://tailwindcss.com)
- 🔍 [Troubleshooting Guide](https://laravel.com/docs/errors)

---

**Dernière mise à jour**: Janvier 2026
**Statut**: Production-Ready
