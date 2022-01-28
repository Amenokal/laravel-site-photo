<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public $fillable = [
        'src',
        'order',
        'galery_id',
        'highlighted'
    ];

    public function galery()
    {
        return $this->belongsTo(Galery::class);
    }

    public function highlighteds()
    {
        return Photo::where('highlighted', true)->get();
    }
}
