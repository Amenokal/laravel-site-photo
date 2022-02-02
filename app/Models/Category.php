<?php

namespace App\Models;

use App\Models\Galery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $fillable = [
        'name',
        'order',
    ];

    public function galeries()
    {
        return $this->hasMany(Galery::class);
    }
}
