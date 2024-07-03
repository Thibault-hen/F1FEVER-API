<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverStandings extends Model
{
    use HasFactory;
    protected $table = "driverStandings";
    protected $primaryKey = "driverStandingsId";
    protected $fillable = [
        "raceId",
        "driverId",
        "points",
        "position",
        "positionText",
        "wins"
    ];
    public $timestamps = false;

    public function races()
    {
        return $this->belongsTo(Races::class, 'raceId', 'raceId');
    }

    public function drivers()
    {
        return $this->belongsTo(Drivers::class, 'driverId', 'driverId');
    }
}
