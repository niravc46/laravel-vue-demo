<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'properties';
    protected $fillable = [
        'name', 'details', 'type','size','owner_id','address','brochure'
    ];
    protected $casts = [
        'deleted_at',
        'size' => 'array'
    ];

    //relation with user table
    public function user(){
        return $this->belongsTo(User::class, 'owner_id');
    }

    // relation with image table
    public function images(){
        return $this->hasMany(Image::class, 'property_id', 'id');
    }

    // relation with properties_amenities table
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class,'properties_amenities', 'property_id','amenity_id')->withTimestamps();
    }

    // scop of search
    public function scopeOfSearch($query, $q)
    {
        if ($q) {
        $query->Where('name', 'LIKE', '%' . $q . '%')
                ->orWhere('details', 'LIKE', '%' . $q . '%')
                ->orWhere('type', 'LIKE', '%' . $q . '%')
                ->orWhere('size', 'LIKE', '%' . $q . '%')
                ->orWhere('address', 'LIKE', '%' . $q . '%');
        }
        return $query;
    }

    // Sorting
    public function scopeOfSort($query, $sort = [])
    {
        if ( ! empty($sort) ) {
            foreach ( $sort as $column => $direction ) {
                $query->orderBy($column, $direction);
            }
        }
        else {
            $query->orderBy('updated_at','desc');
        }
        return $query;
    }

}
