<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circuits extends Model
{
    use HasFactory;
    protected $table = "circuits";
    protected $primaryKey = "circuitId";
    protected $fillable = [
        "circuitRef",
        "name",
        "location",
        "country",
        "lat",
        "lng",
        "alt",
        "url"
    ];
    public $timestamps = false;

    public function races()
    {
        return $this->hasMany(Races::class, 'circuitId', 'circuitId');
    }
}
