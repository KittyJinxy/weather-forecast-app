<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'country', 'ip_address'];

    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }
}
