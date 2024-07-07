<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    use HasFactory;
    protected $table = "status";
    protected $primaryKey = "statusId";
    protected $fillable = [
        "status"
    ];
    public $timestamps = false;

    public function results(): HasMany
    {
        return $this->hasMany(Results::class, 'statusId', 'statusId');
    }
}
