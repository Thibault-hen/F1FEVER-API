<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Constructors extends Model
{
    use HasFactory;
    protected $table = "constructors";
    protected $primaryKey = "constructorId";
    protected $fillable = [
        "constructorRef",
        "name",
        "nationality",
        "url"
    ];
    public $timestamps = false;

    public function results(): HasMany
    {
        return $this->hasMany(Results::class, 'constructorId', 'constructorId');
    }

    public function sprintResults(): HasMany
    {
        return $this->hasMany(Sprintresults::class, 'constructorId', 'constructorId');
    }
}
