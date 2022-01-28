<?php

namespace App\Models;

use App\Models\Galerie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'order',
    ];

    public function galeries()
    {
        return $this->hasMany(Galery::class);
    }
}
