<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstructorResults extends Model
{
    use HasFactory;
    protected $table = "constructorresults";
    protected $primaryKey = "constructorResultsId";
    protected $fillable = [
        "raceId",
        "constructorId",
        "points",
        "status"
    ];
    public $timestamps = false;
}
