<?php

namespace App\Providers;

use App\Models\Galery;
use App\Models\Category;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class SortOrderProvider extends ServiceProvider
{

    public static function sortCategories()
    {
        $categories = Category::orderBy('order')->get();

        $i = 0;
        foreach($categories as $catg){
            $catg->update(['order'=>$i]);
            $i++;
        }
    }

    public static function sortGaleries()
    {
        $categories = Category::all();
        foreach($categories as $catg){
            $i = 0;
            foreach($catg->galeries->sortBy('order')->all() as $gal){
                $gal->update(['order'=>$i]);
                $i++;
            }
        }
    }

    public static function sortPhotos()
    {
        $galeries = Galery::all();
        foreach($galeries as $gal){
            $i = 0;
            foreach($gal->photos->sortBy('order')->all() as $photo){
                $photo->update(['order'=>$i]);
                $i++;
            }
        }
    }

}
