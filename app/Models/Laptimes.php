<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptimes extends Model
{
    use HasFactory;
    
    protected $table = "laptimes";
    protected $primaryKey = ["raceId", "driverId", "lap"]; // Define composite primary key
    protected $fillable = [
        'raceId',
        'driverId',
        "position",
        "time",
        "milliseconds"
    ];
    public $timestamps = false;
    
    public function races()
    {
        return $this->belongsTo(Races::class, 'raceId');
    }
}