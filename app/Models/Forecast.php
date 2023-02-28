<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable = ['location_id', 'date', 'icon', 'description', 'max_temp', 'min_temp'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
