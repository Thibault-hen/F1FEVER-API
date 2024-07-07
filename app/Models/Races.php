<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Races extends Model
{
    use HasFactory;
    protected $table = "races";
    protected $primaryKey = "raceId";
    protected $fillable = [
        "year",
        "round",
        "circuitId",
        "name",
        "date",
        "time",
        "url",
        "fp1_date",
        "fp1_time",
        "fp2_date",
        "fp2_time",
        "fp3_date",
        "fp3_time",
        "quali_date",
        "quali_time",
        "sprint_date",
        "sprint_time"
    ];
    public $timestamps = false;

    public function laptimes(): HasMany
    {
        return $this->hasMany(Laptimes::class, 'raceId');
    }

    public function driverStandings(): HasMany
    {
        return $this->hasMany(DriverStandings::class, 'raceId', 'raceId');
    }

    public function qualifying(): HasMany
    {
        return $this->hasMany(Qualifying::class, 'raceId');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Results::class, 'raceId', 'raceId');
    }

    public function circuits(): BelongsTo
    {
        return $this->belongsTo(Circuits::class, 'circuitId', 'circuidId');
    }
}
