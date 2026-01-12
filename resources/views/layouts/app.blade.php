<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LuxeAuto - Voitures de Luxe Exceptionnelles')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .btn-luxury {
            @apply px-8 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold transition duration-300 rounded-lg;
        }
        
        .btn-outline {
            @apply px-8 py-3 border-2 border-yellow-600 text-yellow-600 hover:bg-yellow-600 hover:text-white font-semibold transition duration-300 rounded-lg;
        }
        
        .hero-overlay {
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 100%);
        }
        
        .card-luxury {
            @apply bg-white dark:bg-gray-900 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-105;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white dark:bg-gray-900 shadow-md z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold text-yellow-600">
                <a href="{{ route('home') }}">LuxeAuto</a>
            </div>
            <div class="hidden md:flex gap-8">
                <a href="{{ route('home') }}" class="hover:text-yellow-600 transition">Accueil</a>
                <a href="{{ route('cars.index') }}" class="hover:text-yellow-600 transition">Voitures</a>
                <a href="{{ route('cars.search') }}" class="hover:text-yellow-600 transition">Recherche</a>
                <a href="#contact" class="hover:text-yellow-600 transition">Contact</a>
            </div>
            <button class="md:hidden text-yellow-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-100 py-12 mt-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold text-yellow-600 mb-4">LuxeAuto</h3>
                    <p class="text-gray-400">Votre destination pour les automobiles de luxe les plus exclusives.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Navigation</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-yellow-600">Accueil</a></li>
                        <li><a href="{{ route('cars.index') }}" class="hover:text-yellow-600">Voitures</a></li>
                        <li><a href="{{ route('cars.search') }}" class="hover:text-yellow-600">Recherche</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Téléphone: +33 1 23 45 67 89</li>
                        <li>Email: contact@luxeauto.fr</li>
                        <li>Adresse: Paris, France</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Suivez-nous</h4>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-yellow-600">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-yellow-600">Instagram</a>
                        <a href="#" class="text-gray-400 hover:text-yellow-600">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; 2026 LuxeAuto. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>
