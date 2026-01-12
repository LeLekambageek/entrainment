<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'logo_path', 'country', 'year_founded'];

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }
}
