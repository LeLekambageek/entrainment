<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Brand;
use Illuminate\View\View;

class CarController extends Controller
{
    public function index(string $brand = null): View
    {
        $query = Car::where('is_available', true)
            ->with('brand')
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at');

        if ($brand) {
            $query->whereHas('brand', function ($q) use ($brand) {
                $q->where('slug', $brand);
            });
        }

        $cars = $query->paginate(12);
        $brands = Brand::withCount('cars')->get();

        return view('cars.index', compact('cars', 'brands', 'brand'));
    }

    public function show(string $slug): View
    {
        $car = Car::where('slug', $slug)
            ->with(['brand', 'images', 'features'])
            ->firstOrFail();

        $car->increment('views');

        $relatedCars = Car::where('brand_id', $car->brand_id)
            ->where('id', '!=', $car->id)
            ->where('is_available', true)
            ->limit(3)
            ->get();

        return view('cars.show', compact('car', 'relatedCars'));
    }

    public function search(): View
    {
        $query = request('q', '');
        $brand = request('brand');
        $fuelType = request('fuel_type');
        $transmission = request('transmission');
        $priceMin = request('price_min');
        $priceMax = request('price_max');

        $cars = Car::where('is_available', true);

        if ($query) {
            $cars->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('model', 'like', "%{$query}%")
                    ->orWhereHas('brand', function ($q) use ($query) {
                        $q->where('name', 'like', "%{$query}%");
                    });
            });
        }

        if ($brand) {
            $cars->whereHas('brand', function ($q) use ($brand) {
                $q->where('slug', $brand);
            });
        }

        if ($fuelType) {
            $cars->where('fuel_type', $fuelType);
        }

        if ($transmission) {
            $cars->where('transmission', $transmission);
        }

        if ($priceMin) {
            $cars->where('price', '>=', $priceMin);
        }

        if ($priceMax) {
            $cars->where('price', '<=', $priceMax);
        }

        $cars = $cars->with('brand')->paginate(12);
        $brands = Brand::all();

        return view('cars.search', compact('cars', 'brands', 'query'));
    }
}
