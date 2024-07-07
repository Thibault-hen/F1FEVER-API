<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qualifying extends Model
{
    use HasFactory;
    protected $table = "qualifying";
    protected $primaryKey = "qualifyId";
    protected $fillable = [
        "raceId",
        "driverId",
        "constructorId",
        "number",
        "position",
        "q1",
        "q2",
        "q3"
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

    public function results(): BelongsTo
    {
        return $this->belongsTo(Results::class, 'raceId', 'raceId')
                        ->where('results.driverId', 'driverId');  
    }
}
