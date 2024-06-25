<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptimes extends Model
{
    use HasFactory;
    protected $table = "laptimes";
    protected $primaryKey = ["raceId", "driverId", "lap"];
    protected $fillable = [
        "position",
        "time",
        "milliseconds"
    ];
    public $timestamps = false;
}
