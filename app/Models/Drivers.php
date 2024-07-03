<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function driverStandings()
    {
        return $this->hasMany(DriverStandings::class, 'driverId', 'driverId');
    }

    public function results()
    {
        return $this->hasMany(Results::class, 'driverId', 'driverId');
    }

    public function qualifying()
    {
        return $this->hasMany(Qualifying::class, 'driverId', 'driverId');
    }
}
