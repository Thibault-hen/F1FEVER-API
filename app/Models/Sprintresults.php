<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sprintresults extends Model
{
    use HasFactory;
    protected $table = "sprintresults";
    protected $primaryKey = "sprintResultId";
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
        "times",
        "milliseconds",
        "fastestLap",
        "fastestLapTime",
        "statusId"
    ];
    public $timestamps = false;

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Drivers::class, 'driverId', 'driverId');
    }
}
