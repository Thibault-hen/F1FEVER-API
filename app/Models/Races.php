<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function laptimes()
    {
        return $this->hasMany(Laptimes::class, 'raceId');
    }
}
