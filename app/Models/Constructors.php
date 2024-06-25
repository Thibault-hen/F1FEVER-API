<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
