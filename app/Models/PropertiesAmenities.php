<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertiesAmenities extends Model
{
    use HasFactory;

    protected $table = 'properties_amenities';
    protected $guarded = [];
}
