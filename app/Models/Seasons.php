<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seasons extends Model
{
    use HasFactory;
    protected $table = "seasons";
    protected $primaryKey = "year";
    protected $fillable = [
        "url"
    ];
    public $timestamps = false;
}
