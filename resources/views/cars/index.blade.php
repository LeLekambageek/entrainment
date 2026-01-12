@extends('layouts.app')

@section('title', 'Accueil - LuxeAuto')

@section('content')
<!-- Hero Section -->
<section class="relative h-96 md:h-screen bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center hero-overlay" style="background-image: url('https://images.unsplash.com/photo-1631332703712-01218c436dcb?w=1200&h=800&fit=crop');">
    </div>
    <div class="relative h-full flex items-center justify-center text-center text-white px-6">
        <div class="max-w-2xl">
            <h1 class="text-5xl md:text-7xl font-bold mb-6">Luxe & Prestige</h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-200">Découvrez les plus belles voitures de luxe du monde</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('cars.index') }}" class="btn-luxury">Parcourir les voitures</a>
                <a href="#featured" class="btn-outline">En savoir plus</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Cars -->
<section id="featured" class="py-20 px-6 max-w-7xl mx-auto">
    <h2 class="text-4xl md:text-5xl font-bold text-center mb-12">Sélection Exclusive</h2>
    
    @if($cars->count() > 0)
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($cars->take(3) as $car)
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
                        <h3 class="text-2xl font-bold mb-2">{{ $car->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $car->model }} - {{ $car->year }}</p>
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-600 dark:text-gray-400">
                            <div><strong>Carburant:</strong> {{ $car->fuel_type }}</div>
                            <div><strong>Transmission:</strong> {{ $car->transmission }}</div>
                            <div><strong>Puissance:</strong> {{ $car->horsepower ?? 'N/A' }} ch</div>
                            <div><strong>Couleur:</strong> {{ $car->color }}</div>
                        </div>
                        <a href="{{ route('cars.show', $car->slug) }}" class="btn-luxury w-full text-center">
                            Voir les détails
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('cars.index') }}" class="btn-luxury">Voir toutes les voitures</a>
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-600 dark:text-gray-400 text-xl">Aucune voiture disponible pour le moment.</p>
        </div>
    @endif
</section>

<!-- Brands Section -->
<section class="py-20 px-6 bg-gray-100 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-4xl md:text-5xl font-bold text-center mb-12">Marques Prestigieuses</h2>
        
        @if($brands->count() > 0)
            <div class="grid md:grid-cols-4 gap-8">
                @foreach($brands as $brand)
                    <a href="{{ route('cars.index', ['brand' => $brand->slug]) }}" 
                       class="bg-white dark:bg-gray-800 p-8 rounded-xl text-center hover:shadow-lg transition cursor-pointer">
                        <h3 class="text-2xl font-bold mb-2 text-yellow-600">{{ $brand->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $brand->cars_count }} véhicules</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Stats Section -->
<section class="py-20 px-6 bg-yellow-600 text-white">
    <div class="max-w-7xl mx-auto">
        <div class="grid md:grid-cols-3 gap-12 text-center">
            <div>
                <h3 class="text-5xl font-bold mb-2">{{ \App\Models\Car::count() }}+</h3>
                <p class="text-lg">Véhicules disponibles</p>
            </div>
            <div>
                <h3 class="text-5xl font-bold mb-2">{{ \App\Models\Brand::count() }}</h3>
                <p class="text-lg">Marques prestigieuses</p>
            </div>
            <div>
                <h3 class="text-5xl font-bold mb-2">1000+</h3>
                <p class="text-lg">Clients satisfaits</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 px-6 max-w-7xl mx-auto">
    <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-2xl p-12 text-center">
        <h2 class="text-4xl font-bold mb-4">Vous ne trouvez pas votre rêve ?</h2>
        <p class="text-xl mb-8 text-gray-300">Contactez-nous pour une consultation personnalisée</p>
        <button onclick="document.getElementById('contact-form').scrollIntoView({behavior: 'smooth'})" class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-3 rounded-lg font-bold transition">
            Demander un renseignement
        </button>
    </div>
</section>

<!-- Contact Form -->
<section id="contact-form" class="py-20 px-6 max-w-7xl mx-auto">
    <h2 class="text-4xl font-bold text-center mb-12">Nous Contacter</h2>
    <div class="max-w-2xl mx-auto">
        <form method="POST" action="{{ route('inquiry.store') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-2">Nom</label>
                <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
            </div>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Téléphone</label>
                    <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Message</label>
                <textarea name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600"></textarea>
            </div>
            <button type="submit" class="btn-luxury w-full">Envoyer</button>
        </form>
    </div>
</section>

@endsection
