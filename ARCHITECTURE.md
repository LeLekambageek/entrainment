# 🏗️ Architecture Technique de LuxeAuto

## Vue d'Ensemble du Système

```
┌─────────────────────────────────────────────────────────────────────┐
│                         CLIENT BROWSER                              │
│                    (HTML, CSS, JavaScript)                          │
└────────────────────────────┬────────────────────────────────────────┘
                             │ HTTP/HTTPS
                             │
┌────────────────────────────┴────────────────────────────────────────┐
│                      WEB SERVER (Apache/Nginx)                      │
│                          Laravel 11                                  │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌──────────────┐    ┌──────────────┐    ┌──────────────┐         │
│  │   ROUTES     │    │ CONTROLLERS  │    │ MIDDLEWARE   │         │
│  │   (web.php)  │───▶│ (Car, View)  │───▶│ (CSRF, Auth) │         │
│  └──────────────┘    └──────────────┘    └──────────────┘         │
│         │                    │                    │                 │
│         └────────┬───────────┴────────┬──────────┘                 │
│                  │                    │                            │
│           ┌──────▼────────┐   ┌──────▼────────┐                  │
│           │  MODELS       │   │  VIEWS        │                  │
│           │ (Eloquent ORM)│   │  (Blade)      │                  │
│           │               │   │               │                  │
│           │ • Brand       │   │ • layouts/    │                  │
│           │ • Car         │   │   app.blade   │                  │
│           │ • CarImage    │   │ • cars/       │                  │
│           │ • CarFeature  │   │   index.blade │                  │
│           │ • Inquiry     │   │ • cars/       │                  │
│           │               │   │   show.blade  │                  │
│           └──────┬────────┘   │ • cars/       │                  │
│                  │            │   search.blade│                  │
│                  │            └───────────────┘                  │
│                  │                                                 │
└──────────────────┼─────────────────────────────────────────────────┘
                   │
                   │ SQL Queries
                   │
┌──────────────────┴─────────────────────────────────────────────────┐
│                      DATABASE (MySQL/SQLite)                        │
├─────────────────────────────────────────────────────────────────────┤
│                                                                     │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐            │
│  │   BRANDS     │  │    CARS      │  │  CAR_IMAGES  │            │
│  ├──────────────┤  ├──────────────┤  ├──────────────┤            │
│  │ id (PK)      │  │ id (PK)      │  │ id (PK)      │            │
│  │ name         │  │ brand_id(FK) │  │ car_id(FK)   │            │
│  │ slug         │◄─│ name         │  │ image_path   │            │
│  │ description  │  │ slug         │  │ alt_text     │            │
│  │ country      │  │ model        │  │ sort_order   │            │
│  │ year_founded │  │ year         │  │ created_at   │            │
│  │ created_at   │  │ color        │  │ updated_at   │            │
│  │ updated_at   │  │ price        │  └──────────────┘            │
│  └──────────────┘  │ mileage      │                              │
│                    │ fuel_type    │  ┌──────────────┐            │
│                    │ transmission │  │CAR_FEATURES  │            │
│                    │ horsepower   │  ├──────────────┤            │
│                    │ engine_disp. │  │ id (PK)      │            │
│                    │ description  │  │ car_id(FK)   │            │
│                    │ featured_img │  │ feature_name │            │
│                    │ is_available │  │ description  │            │
│                    │ is_featured  │  │ created_at   │            │
│                    │ views        │  │ updated_at   │            │
│                    │ created_at   │  └──────────────┘            │
│                    │ updated_at   │                              │
│                    └──────────────┘  ┌──────────────┐            │
│                                      │ INQUIRIES    │            │
│                                      ├──────────────┤            │
│                                      │ id (PK)      │            │
│                                      │ car_id(FK)   │            │
│                                      │ name         │            │
│                                      │ email        │            │
│                                      │ phone        │            │
│                                      │ message      │            │
│                                      │ status       │            │
│                                      │ created_at   │            │
│                                      │ updated_at   │            │
│                                      └──────────────┘            │
│                                                                     │
└─────────────────────────────────────────────────────────────────────┘
```

## Flux de Requête

```
1. USER VISIT
   │
   └─► http://localhost:8000/
       │
       └─► INDEX ROUTE (GET /)
           │
           └─► CarController@index()
               │
               ├─► SELECT * FROM cars WHERE is_available=1
               │   (Eager load: brand, images, features)
               │
               ├─► Paginate results (12 per page)
               │
               └─► Return view('cars.index', $data)
                   │
                   └─► Render Blade template
                       │
                       └─► Send HTML to Browser

2. USER SEARCHES
   │
   └─► http://localhost:8000/search?q=ferrari&price_min=100000
       │
       └─► SEARCH ROUTE (GET /search)
           │
           └─► CarController@search()
               │
               ├─► Build query with filters
               │   - Recherche textuelle (LIKE)
               │   - Brand filter (whereHas)
               │   - Fuel type filter
               │   - Transmission filter
               │   - Price range filter
               │
               ├─► Execute query
               │
               └─► Return paginated results

3. USER VIEWS DETAIL
   │
   └─► http://localhost:8000/voitures/ferrari-f8-tributo
       │
       └─► SHOW ROUTE (GET /voitures/{slug})
           │
           └─► CarController@show($slug)
               │
               ├─► Car::where('slug', $slug)
               │   ->with(['brand', 'images', 'features'])
               │   ->firstOrFail()
               │
               ├─► Increment views counter
               │
               ├─► Get related cars (same brand)
               │
               └─► Return view('cars.show', $data)

4. USER SUBMITS INQUIRY
   │
   └─► POST /inquiry
       │
       └─► InquiryController@store()
           │
           ├─► Validate form data
           │   - name (required, string, max 255)
           │   - email (required, email)
           │   - phone (required, string, max 20)
           │   - message (nullable, string, max 1000)
           │   - car_id (nullable, exists in cars)
           │
           ├─► Save to database
           │   INSERT INTO inquiries (...)
           │
           └─► Redirect back with success message
```

## Structure des Fichiers

### Backend (PHP/Laravel)

```
app/
├── Models/
│   ├── Brand.php
│   │   ├── Attributes: name, slug, description, logo, country, year_founded
│   │   └── Relations: hasMany(Car)
│   │
│   ├── Car.php
│   │   ├── Attributes: price, year, color, fuel_type, transmission, etc.
│   │   └── Relations: 
│   │       ├── belongsTo(Brand)
│   │       ├── hasMany(CarImage)
│   │       ├── hasMany(CarFeature)
│   │       └── hasMany(Inquiry)
│   │
│   ├── CarImage.php
│   │   ├── Attributes: image_path, alt_text, sort_order
│   │   └── Relations: belongsTo(Car)
│   │
│   ├── CarFeature.php
│   │   ├── Attributes: feature_name, description
│   │   └── Relations: belongsTo(Car)
│   │
│   └── Inquiry.php
│       ├── Attributes: name, email, phone, message, status
│       └── Relations: belongsTo(Car)
│
└── Http/Controllers/
    ├── CarController.php
    │   ├── index() - Affiche le catalogue
    │   ├── show($slug) - Affiche les détails
    │   └── search() - Recherche avancée
    │
    └── InquiryController.php
        └── store() - Enregistre une demande
```

### Frontend (Blade/HTML)

```
resources/views/
├── layouts/
│   └── app.blade.php
│       ├── Navigation
│       ├── @yield('content')
│       └── Footer
│
└── cars/
    ├── index.blade.php
    │   ├── Hero Section
    │   ├── Featured Cars Grid
    │   ├── Brands Section
    │   ├── Statistics
    │   └── Contact Form
    │
    ├── show.blade.php
    │   ├── Hero with Image
    │   ├── Gallery with Thumbnails
    │   ├── Specifications
    │   ├── Description
    │   ├── Features List
    │   ├── Contact Form
    │   └── Related Cars
    │
    └── search.blade.php
        ├── Advanced Filter Form
        ├── Results Grid
        └── Pagination
```

### Database (SQL)

```
TABLES:
├── users (Laravel default)
├── brands
│   └── Many ──► cars
├── cars
│   ├── Many ──► car_images
│   ├── Many ──► car_features
│   └── Many ──► inquiries
├── car_images
├── car_features
├── inquiries
│   └── One ──► cars
└── cache/sessions (Laravel default)
```

## Flux de Données

### Query Patterns

```php
// 1. Eager Loading (Recommended)
$cars = Car::with(['brand', 'images', 'features'])->paginate(12);

// 2. Filtered Search
$cars = Car::where('is_available', true)
    ->whereHas('brand', fn($q) => $q->where('slug', 'ferrari'))
    ->where('fuel_type', 'Essence')
    ->whereBetween('price', [100000, 500000])
    ->paginate(12);

// 3. Related Items
$related = Car::where('brand_id', $car->brand_id)
    ->where('id', '!=', $car->id)
    ->limit(3)
    ->get();
```

## Performance Optimization

### Database Indexes
```sql
-- Créés automatiquement:
- cars.id (PRIMARY KEY)
- cars.brand_id (FOREIGN KEY)
- cars.slug (UNIQUE)
- cars.is_available (indexed)
```

### Query Optimization
```php
// Eager Loading prevents N+1 queries:
Bad:  $cars = Car::all();
      foreach ($cars as $car) {
          echo $car->brand->name; // 1 + N queries!
      }

Good: $cars = Car::with('brand')->get();
      foreach ($cars as $car) {
          echo $car->brand->name; // 2 queries only
      }
```

### Caching Strategy
```php
// Could be implemented:
$brands = Cache::remember('brands:all', 3600, function() {
    return Brand::withCount('cars')->get();
});
```

## Security Measures

```
✓ Input Validation
  - All form inputs validated server-side
  - Type casting in models

✓ CSRF Protection
  - {{ csrf_field() }} in all forms
  - Middleware verification

✓ SQL Injection Prevention
  - Parameterized queries (Eloquent)
  - No raw SQL in controllers

✓ XSS Protection
  - Blade escaping by default
  - {{ }} escapes output

✓ Data Integrity
  - Foreign key constraints
  - Unique slug constraint
  - Required field validation

✓ Error Handling
  - No detailed errors in production
  - Proper exception handling
```

## Deployment Architecture

```
Production Setup:
┌─────────────────────────────────────────┐
│         Load Balancer (Optional)        │
└──────────────┬──────────────────────────┘
               │
┌──────────────┴──────────────────────────┐
│      Web Servers (1 or more)            │
│  ├─ PHP-FPM                             │
│  ├─ Laravel App                         │
│  └─ Nginx/Apache                        │
└──────────┬───────────────────────────────┘
           │
┌──────────┴───────────────────────────────┐
│      Database Server (MySQL)             │
│  ├─ Database luxeauto                    │
│  └─ Backups (daily)                      │
└──────────────────────────────────────────┘

Optional:
├─ Redis (Caching)
├─ Storage Server (Images)
├─ Email Queue (Notifications)
└─ Monitoring (New Relic, DataDog)
```

## API Response Examples

### Homepage Data
```json
{
  "featured_cars": [
    {
      "id": 1,
      "name": "Ferrari F8 Tributo",
      "slug": "ferrari-f8-tributo",
      "price": 280000,
      "brand": {
        "id": 1,
        "name": "Ferrari"
      },
      "featured_image": "cars/ferrari-f8.jpg"
    }
  ],
  "brands": [
    {
      "id": 1,
      "name": "Ferrari",
      "cars_count": 1
    }
  ]
}
```

### Car Detail Data
```json
{
  "car": {
    "id": 1,
    "name": "Ferrari F8 Tributo",
    "brand": { "id": 1, "name": "Ferrari" },
    "specifications": {
      "year": 2023,
      "price": 280000,
      "horsepower": 710,
      "transmission": "Automatique"
    },
    "images": [
      {
        "id": 1,
        "image_path": "cars/ferrari-1.jpg",
        "alt_text": "Ferrari F8 - Vue avant"
      }
    ],
    "features": [
      {
        "id": 1,
        "feature_name": "Climatisation automatique"
      }
    ]
  }
}
```

---

**Architecture créée**: Janvier 2026
**Statut**: Production-Ready
**Scalability**: Prêt pour croissance
