<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructorStandings extends Model
{
    use HasFactory;
    protected $table = "constructorStandings";
    protected $primaryKey = "constructorStandingsId";
    protected $fillable = [
        "raceId",
        "constructorId",
        "points",
        "position",
        "positionText",
        "wins"
    ];
    public $timestamps = false;
}
