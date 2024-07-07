<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drivers extends Model
{
    use HasFactory;
    protected $table = "drivers";
    protected $primaryKey = "driverId";
    protected $fillable = [
        "driverRef",
        "number",
        "code",
        "forename",
        "surname",
        "dob",
        "nationality",
        "url"
    ];
    public $timestamps = false;

    public function driverStandings(): HasMany
    {
        return $this->hasMany(DriverStandings::class, 'driverId', 'driverId');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Results::class, 'driverId', 'driverId');
    }

    public function sprintResults(): HasMany
    {
        return $this->hasMany(Sprintresults::class, 'driverId', 'driverId');
    }

    public function qualifying(): HasMany
    {
        return $this->hasMany(Qualifying::class, 'driverId', 'driverId');
    }
}
