<?php

namespace App\Models;

use App\Traits\ValidForRange;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartmentPrice extends Model
{
    use HasFactory;
    use ValidForRange;

    protected $fillable = [
        'apartment_id',
        'start_date',
        'end_date',
        'price'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

}
