<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
