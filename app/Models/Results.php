<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function races()
    {
        return $this->belongsTo(Races::class, 'raceId', 'raceId');
    }

    public function drivers()
    {
        return $this->belongsTo(Drivers::class, 'driverId', 'driverId');
    }

    public function constructors()
    {
        return $this->belongsTo(Constructors::class, 'constructorId', 'constructorId');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'statusId', 'statusId');
    }
    
    public function sprintResults()
    {
        return $this->hasOne(Sprintresults::class, 'driverId', 'driverId');
    }
    
    public function qualifying()
    {
        return $this->hasOne(Qualifying::class, 'raceId', 'raceId')
                    ->whereColumn('qualifying.driverId', 'driverId');
    }
}
