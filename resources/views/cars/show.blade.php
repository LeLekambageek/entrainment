@extends('layouts.app')

@section('title', $car->name . ' - LuxeAuto')

@section('content')

<!-- Hero Section with Car Image -->
<section class="relative h-screen bg-gray-900 overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center hero-overlay" style="background-image: url('{{ $car->featured_image ? asset('storage/' . $car->featured_image) : 'https://images.unsplash.com/photo-1609708536965-59d1afdf69e0?w=1200&h=800&fit=crop' }}');">
    </div>
    <div class="relative h-full flex items-center justify-center text-white px-6">
        <div class="text-center max-w-2xl">
            <h1 class="text-6xl md:text-7xl font-bold mb-4">{{ $car->name }}</h1>
            <p class="text-3xl text-yellow-400 font-bold">{{ number_format($car->price, 0, ',', ' ') }} €</p>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-20 px-6 max-w-7xl mx-auto">
    <div class="grid md:grid-cols-3 gap-12">
        <!-- Left Column: Info -->
        <div class="md:col-span-2">
            <!-- Gallery -->
            <div class="mb-12">
                <div class="relative overflow-hidden rounded-xl mb-4 bg-gray-200">
                    <img id="main-image" 
                         src="{{ $car->featured_image ? asset('storage/' . $car->featured_image) : 'https://images.unsplash.com/photo-1609708536965-59d1afdf69e0?w=800&h=600&fit=crop' }}" 
                         alt="{{ $car->name }}" 
                         class="w-full h-96 object-cover">
                </div>
                
                @if($car->images->count() > 0)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($car->images as $image)
                            <button onclick="document.getElementById('main-image').src = '{{ asset('storage/' . $image->image_path) }}'" 
                                    class="overflow-hidden rounded-lg border-2 border-transparent hover:border-yellow-600 transition">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text ?? $car->name }}" class="w-full h-24 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Details Grid -->
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-8 mb-12">
                <h2 class="text-3xl font-bold mb-8">Caractéristiques Techniques</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Marque</h3>
                        <p class="text-xl">{{ $car->brand->name }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Modèle</h3>
                        <p class="text-xl">{{ $car->model }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Année</h3>
                        <p class="text-xl">{{ $car->year }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Couleur</h3>
                        <p class="text-xl">{{ $car->color }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Carburant</h3>
                        <p class="text-xl">{{ $car->fuel_type }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Transmission</h3>
                        <p class="text-xl">{{ $car->transmission }}</p>
                    </div>
                    @if($car->horsepower)
                        <div>
                            <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Puissance</h3>
                            <p class="text-xl">{{ $car->horsepower }} ch</p>
                        </div>
                    @endif
                    @if($car->engine_displacement)
                        <div>
                            <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Cylindrée</h3>
                            <p class="text-xl">{{ $car->engine_displacement }} L</p>
                        </div>
                    @endif
                    @if($car->mileage)
                        <div>
                            <h3 class="font-bold text-gray-600 dark:text-gray-400 mb-2">Kilométrage</h3>
                            <p class="text-xl">{{ number_format($car->mileage, 0, ',', ' ') }} km</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">Description</h2>
                <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">{{ $car->description }}</p>
            </div>

            <!-- Features -->
            @if($car->features->count() > 0)
                <div class="mb-12">
                    <h2 class="text-3xl font-bold mb-6">Équipements</h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($car->features as $feature)
                            <div class="flex items-start">
                                <span class="text-yellow-600 mr-3">✓</span>
                                <div>
                                    <h3 class="font-bold">{{ $feature->feature_name }}</h3>
                                    @if($feature->description)
                                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $feature->description }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Right Column: Contact Form -->
        <div class="sticky top-32 h-fit">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-xl p-8">
                <h3 class="text-2xl font-bold mb-6">Nous Contacter</h3>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('inquiry.store') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nom</label>
                        <input type="text" name="name" required 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2">Email</label>
                        <input type="email" name="email" required 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2">Téléphone</label>
                        <input type="tel" name="phone" required 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold mb-2">Message</label>
                        <textarea name="message" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-600"></textarea>
                    </div>
                    
                    <button type="submit" class="btn-luxury w-full">
                        Demander un Renseignement
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-300 dark:border-gray-700">
                    <h4 class="font-bold mb-4">Contactez-nous Directement</h4>
                    <div class="space-y-3 text-gray-700 dark:text-gray-300">
                        <p>📞 +33 1 23 45 67 89</p>
                        <p>✉️ contact@luxeauto.fr</p>
                        <p>📍 Paris, France</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Cars -->
@if($relatedCars->count() > 0)
    <section class="py-20 px-6 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12">Voitures Similaires</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($relatedCars as $relatedCar)
                    <div class="card-luxury">
                        <div class="relative overflow-hidden h-64">
                            <img src="{{ $relatedCar->featured_image ? asset('storage/' . $relatedCar->featured_image) : 'https://images.unsplash.com/photo-1609708536965-59d1afdf69e0?w=600&h=400&fit=crop' }}" 
                                 alt="{{ $relatedCar->name }}" 
                                 class="w-full h-full object-cover hover:scale-110 transition duration-300">
                            <div class="absolute top-4 right-4 bg-yellow-600 text-white px-4 py-2 rounded-lg font-bold">
                                {{ number_format($relatedCar->price, 0, ',', ' ') }} €
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold mb-2">{{ $relatedCar->name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $relatedCar->model }} - {{ $relatedCar->year }}</p>
                            <a href="{{ route('cars.show', $relatedCar->slug) }}" class="btn-luxury w-full text-center block">
                                Voir les détails
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@endsection
