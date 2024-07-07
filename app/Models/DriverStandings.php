<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function races(): BelongsTo
    {
        return $this->belongsTo(Races::class, 'raceId', 'raceId');
    }

    public function drivers(): BelongsTo
    {
        return $this->belongsTo(Drivers::class, 'driverId', 'driverId');
    }
}
