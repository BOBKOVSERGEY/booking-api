<?php

namespace App\Models;

use App\Observers\PropertyObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'city_id',
        'address_street',
        'address_postcode',
        'lat',
        'long',
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public static function booted()
    {
        parent::booted();

        self::observe(PropertyObserver::class);
    }

    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }
}
