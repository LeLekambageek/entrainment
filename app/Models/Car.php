<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'model',
        'year',
        'color',
        'price',
        'mileage',
        'fuel_type',
        'transmission',
        'horsepower',
        'engine_displacement',
        'description',
        'featured_image',
        'is_available',
        'is_featured',
        'views'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured' => 'boolean',
        'engine_displacement' => 'float'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(CarFeature::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }
}
