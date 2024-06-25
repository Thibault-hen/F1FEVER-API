<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitstops extends Model
{
    use HasFactory;
    protected $table = "pitstops";
    protected $primaryKey = ["raceId", "driverId", "stop"];
    protected $fillable = [
        "lap",
        "time",
        "duration",
        "milliseconds"
    ];
    public $timestamps = false;
}
