<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Results extends Model
{
    use HasFactory;
    protected $table = "results";
    protected $primaryKey = "resultId";
    protected $fillable = [
        "raceId",
        "driverId",
        "constructorId",
        "number",
        "grid",
        "position",
        "positionText",
        "positionOrder",
        "points",
        "laps",
        "time",
        "milliseconds",
        "fastestLap",
        "rank",
        "fastestLapTime",
        "fastestLapSpeed",
        "statusId"
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

    public function constructors(): BelongsTo
    {
        return $this->belongsTo(Constructors::class, 'constructorId', 'constructorId');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'statusId', 'statusId');
    }
    
    public function sprintResults(): HasOne
    {
        return $this->hasOne(Sprintresults::class, 'driverId', 'driverId');
    }
    
    public function qualifying(): HasOne
    {
        return $this->hasOne(Qualifying::class, 'raceId', 'raceId')
                    ->whereColumn('qualifying.driverId', 'driverId');
    }
}
