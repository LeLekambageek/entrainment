<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarFeature;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create brands
        $brands = [
            [
                'name' => 'Ferrari',
                'slug' => 'ferrari',
                'description' => 'La légende italienne de vitesse et de prestige',
                'country' => 'Italie',
                'year_founded' => 1947
            ],
            [
                'name' => 'Lamborghini',
                'slug' => 'lamborghini',
                'description' => 'L\'excellence italienne en matière de supercars',
                'country' => 'Italie',
                'year_founded' => 1963
            ],
            [
                'name' => 'Porsche',
                'slug' => 'porsche',
                'description' => 'Ingénierie allemande de pointe',
                'country' => 'Allemagne',
                'year_founded' => 1948
            ],
            [
                'name' => 'Bentley',
                'slug' => 'bentley',
                'description' => 'Luxe britannique intemporel',
                'country' => 'Royaume-Uni',
                'year_founded' => 1919
            ],
            [
                'name' => 'Rolls-Royce',
                'slug' => 'rolls-royce',
                'description' => 'Le summum du luxe automobile',
                'country' => 'Royaume-Uni',
                'year_founded' => 1906
            ],
            [
                'name' => 'Mercedes-Benz',
                'slug' => 'mercedes-benz',
                'description' => 'Excellence allemande et innovation',
                'country' => 'Allemagne',
                'year_founded' => 1926
            ],
            [
                'name' => 'BMW',
                'slug' => 'bmw',
                'description' => 'Joie de conduire',
                'country' => 'Allemagne',
                'year_founded' => 1916
            ],
            [
                'name' => 'Bugatti',
                'slug' => 'bugatti',
                'description' => 'Hyper-voitures de performance extrême',
                'country' => 'France',
                'year_founded' => 1909
            ]
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(['slug' => $brand['slug']], $brand);
        }

        // Create cars
        $cars = [
            [
                'brand_id' => Brand::where('slug', 'ferrari')->first()->id,
                'name' => 'Ferrari F8 Tributo',
                'slug' => 'ferrari-f8-tributo',
                'model' => 'F8 Tributo',
                'year' => 2023,
                'color' => 'Rosso Corsa',
                'price' => 280000,
                'mileage' => 5000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 710,
                'engine_displacement' => 3.9,
                'description' => 'Le chef-d\'œuvre de Ferrari. Avec son moteur V8 biturbo de 710 chevaux, la F8 Tributo offre des performances exceptionnelles et un design intemporel. Chaque détail a été soigneusement travaillé pour offrir une expérience de conduite inoubliable.',
                'is_available' => true,
                'is_featured' => true
            ],
            [
                'brand_id' => Brand::where('slug', 'lamborghini')->first()->id,
                'name' => 'Lamborghini Huracán',
                'slug' => 'lamborghini-hurakan',
                'model' => 'Huracán Tecnica',
                'year' => 2023,
                'color' => 'Giallo Stella',
                'price' => 320000,
                'mileage' => 2000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 645,
                'engine_displacement' => 5.2,
                'description' => 'L\'Huracán Tecnica est un chef-d\'œuvre de design et de performance. Avec ses 645 chevaux et son accélération fulgurante, elle incarne la passion italienne pour la vitesse et le luxe.',
                'is_available' => true,
                'is_featured' => true
            ],
            [
                'brand_id' => Brand::where('slug', 'porsche')->first()->id,
                'name' => 'Porsche 911 Turbo',
                'slug' => 'porsche-911-turbo',
                'model' => '911 Turbo',
                'year' => 2023,
                'color' => 'Noir Profond',
                'price' => 200000,
                'mileage' => 8000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 580,
                'engine_displacement' => 3.8,
                'description' => 'La Porsche 911 Turbo est l\'incarnation même de la performance allemande. Rapide, agile et raffinée, elle offre une expérience de conduite sans égale sur route et sur circuit.',
                'is_available' => true,
                'is_featured' => true
            ],
            [
                'brand_id' => Brand::where('slug', 'bentley')->first()->id,
                'name' => 'Bentley Continental GT',
                'slug' => 'bentley-continental-gt',
                'model' => 'Continental GT',
                'year' => 2022,
                'color' => 'Bleu Twilight',
                'price' => 230000,
                'mileage' => 12000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 635,
                'engine_displacement' => 6.0,
                'description' => 'La Bentley Continental GT est le summum du grand tourisme britannique. Avec son intérieur luxueux et ses performances impressionnantes, elle offre le meilleur des deux mondes.',
                'is_available' => true,
                'is_featured' => false
            ],
            [
                'brand_id' => Brand::where('slug', 'rolls-royce')->first()->id,
                'name' => 'Rolls-Royce Ghost',
                'slug' => 'rolls-royce-ghost',
                'model' => 'Ghost',
                'year' => 2022,
                'color' => 'Blanc Glacier',
                'price' => 350000,
                'mileage' => 8000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 563,
                'engine_displacement' => 6.75,
                'description' => 'La Rolls-Royce Ghost est le symbole ultime du luxe et de l\'élégance. Chaque détail respire la qualité et le prestige, offrant une expérience de conduite royale.',
                'is_available' => true,
                'is_featured' => false
            ],
            [
                'brand_id' => Brand::where('slug', 'mercedes-benz')->first()->id,
                'name' => 'Mercedes-AMG G 63',
                'slug' => 'mercedes-amg-g-63',
                'model' => 'G 63',
                'year' => 2023,
                'color' => 'Noir Obsidienne',
                'price' => 180000,
                'mileage' => 5000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 585,
                'engine_displacement' => 4.0,
                'description' => 'Le Mercedes-AMG G 63 combine le luxe avec des capacités tout-terrain impressionnantes. C\'est un véritable SUV de prestige pour les aventuriers de luxe.',
                'is_available' => true,
                'is_featured' => false
            ],
            [
                'brand_id' => Brand::where('slug', 'bmw')->first()->id,
                'name' => 'BMW M8 Competition',
                'slug' => 'bmw-m8-competition',
                'model' => 'M8 Competition',
                'year' => 2023,
                'color' => 'Bleu Alpine',
                'price' => 160000,
                'mileage' => 3000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 625,
                'engine_displacement' => 4.4,
                'description' => 'La BMW M8 Competition est le grand coupé sportif ultime. Avec ses 625 chevaux et son design agressif, elle offre une performance et un confort incomparables.',
                'is_available' => true,
                'is_featured' => false
            ],
            [
                'brand_id' => Brand::where('slug', 'bugatti')->first()->id,
                'name' => 'Bugatti Chiron',
                'slug' => 'bugatti-chiron',
                'model' => 'Chiron',
                'year' => 2021,
                'color' => 'Noir Carbone',
                'price' => 2500000,
                'mileage' => 1000,
                'fuel_type' => 'Essence',
                'transmission' => 'Automatique',
                'horsepower' => 1500,
                'engine_displacement' => 8.0,
                'description' => 'La Bugatti Chiron est l\'une des voitures les plus rapides et les plus exclusives du monde. Avec ses 1500 chevaux, elle redéfinit les limites de la performance automobile.',
                'is_available' => false,
                'is_featured' => false
            ]
        ];

        foreach ($cars as $car) {
            $carModel = Car::firstOrCreate(['slug' => $car['slug']], $car);

            // Add features
            $features = [
                ['feature_name' => 'Climatisation automatique', 'description' => 'Système de climatisation multi-zones'],
                ['feature_name' => 'Cuir premium', 'description' => 'Intérieur en cuir de haute qualité'],
                ['feature_name' => 'Toit panoramique', 'description' => 'Toit ouvrant électrique'],
                ['feature_name' => 'Système audio Bose', 'description' => 'Système de haute fidélité'],
                ['feature_name' => 'GPS premium', 'description' => 'Navigation avec affichage tête haute'],
                ['feature_name' => 'Freins carbone', 'description' => 'Système de freinage haute performance'],
            ];

            foreach ($features as $feature) {
                CarFeature::firstOrCreate(
                    ['car_id' => $carModel->id, 'feature_name' => $feature['feature_name']],
                    $feature
                );
            }
        }
    }
}

