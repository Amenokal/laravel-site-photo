<?php

namespace App\Models;

use App\Models\Photo;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Galery extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'order',
        'category_id'
    ];

    public function categorie()
    {
        return $this->belongsTo(Category::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

}
