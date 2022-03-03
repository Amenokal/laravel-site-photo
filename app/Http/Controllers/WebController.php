<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Galery;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    public function home()
    {
        $home_img = Photo::where('highlighted', true)->inRandomOrder()->first();
        return view('home',[
            'categories' => Category::orderBy('order')->get(),
            'home' => true,
            'home_img' => $home_img
        ]);
    }

    public function getContent($categoryOrder, $galeryOrder)
    {
        $galery = Galery::where([
            'category_id' => Category::where('order', $categoryOrder)->first()->id,
            'order'=>$galeryOrder
        ])->first();

        return view('components.home-galery', [
            'galery' => $galery,
            'home' => false
        ]);
    }

    public function openCarousel($galeryId, $photoOrder)
    {
        $photos = Photo::where([
            'galery_id' => Galery::find($galeryId)->id,
        ])->get();

        $current = Photo::where([
            'galery_id' => Galery::find($galeryId)->id,
            'order' => $photoOrder
        ])->first()->order;

        return view('components.carousel', [
            'photos' => $photos,
            'current' => $current
        ]);
    }

    public function admin()
    {
        $last_category_order = Category::all()->count()+1;
        return view('admin',[
            'categories' => Category::orderBy('order')->get(),
            'galery' => false,
            'last_category_order' => $last_category_order
        ]);
    }
}
