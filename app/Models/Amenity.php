<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $table = 'amenities';
    protected $guarded = [];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'properties_amenities');
    }
}
