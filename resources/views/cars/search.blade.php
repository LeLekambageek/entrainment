@extends('layouts.app')

@section('title', 'Recherche - LuxeAuto')

@section('content')

<!-- Search Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 text-white py-16 px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-5xl font-bold mb-8">Rechercher une Voiture</h1>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('cars.search') }}" class="space-y-6">
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Recherche</label>
                    <input type="text" name="q" placeholder="Marque, modèle..." value="{{ $query }}" 
                           class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2">Marque</label>
                    <select name="brand" class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                        <option value="">Toutes les marques</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2">Carburant</label>
                    <select name="fuel_type" class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                        <option value="">Tous</option>
                        <option value="Essence">Essence</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Électrique">Électrique</option>
                        <option value="Hybride">Hybride</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2">Transmission</label>
                    <select name="transmission" class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                        <option value="">Toutes</option>
                        <option value="Manuelle">Manuelle</option>
                        <option value="Automatique">Automatique</option>
                    </select>
                </div>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-2">Prix minimum (€)</label>
                    <input type="number" name="price_min" placeholder="Min" value="{{ request('price_min') }}"
                           class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold mb-2">Prix maximum (€)</label>
                    <input type="number" name="price_max" placeholder="Max" value="{{ request('price_max') }}"
                           class="w-full px-4 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-yellow-600">
                </div>
            </div>
            
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-3 rounded-lg font-bold transition w-full md:w-auto">
                Rechercher
            </button>
        </form>
    </div>
</section>

<!-- Results -->
<section class="py-20 px-6 max-w-7xl mx-auto">
    @if($cars->count() > 0)
        <div class="mb-8">
            <p class="text-gray-600 dark:text-gray-400">
                {{ $cars->total() }} voiture(s) trouvée(s)
                @if($query)
                    pour "<strong>{{ $query }}</strong>"
                @endif
            </p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-8">
            @foreach($cars as $car)
                <div class="card-luxury">
                    <div class="relative overflow-hidden h-64">
                        <img src="{{ $car->featured_image ? asset('storage/' . $car->featured_image) : 'https://images.unsplash.com/photo-1609708536965-59d1afdf69e0?w=600&h=400&fit=crop' }}" 
                             alt="{{ $car->name }}" 
                             class="w-full h-full object-cover hover:scale-110 transition duration-300">
                        <div class="absolute top-4 right-4 bg-yellow-600 text-white px-4 py-2 rounded-lg font-bold">
                            {{ number_format($car->price, 0, ',', ' ') }} €
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $car->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">{{ $car->model }} - {{ $car->year }}</p>
                        <div class="text-xs text-gray-500 space-y-1 mb-4">
                            <p>{{ $car->fuel_type }} • {{ $car->transmission }}</p>
                            @if($car->mileage)
                                <p>{{ number_format($car->mileage, 0, ',', ' ') }} km</p>
                            @endif
                        </div>
                        <a href="{{ route('cars.show', $car->slug) }}" class="btn-luxury w-full text-center text-sm">
                            Détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $cars->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-2xl text-gray-600 dark:text-gray-400 mb-4">
                Aucune voiture ne correspond à votre recherche.
            </p>
            <a href="{{ route('cars.index') }}" class="btn-luxury">Voir toutes les voitures</a>
        </div>
    @endif
</section>

@endsection
