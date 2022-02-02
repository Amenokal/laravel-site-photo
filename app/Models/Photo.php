<?php

namespace App\Models;

use App\Models\Galery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;

    public $timestamps = false;
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
