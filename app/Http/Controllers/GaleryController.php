<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Providers\SortOrderProvider;
use Illuminate\Support\Facades\Storage;

class GaleryController extends Controller
{
    public function create(Request $request)
    {
        if($request->name){
            $catg = Category::where('name', $request->categoryName)->first();

            Galery::create([
                'category_id' => $catg->id,
                'name' => $request->name,
                'order' => $catg->galeries()->count()+1
            ]);

            return view('components.admin-navbar',[
                'categories' => Category::orderBy('order')->get(),
                'lastcategoryorder' => Category::all()->count()+1
            ]);
        }
    }

    public function show($galeryName)
    {
        $galery = Galery::where('name', $galeryName)->first();

        return view('components.admin-galery',[
            'galery' => $galery
        ]);
    }

    public function edit(Request $request)
    {
        Galery::where('name', $request->name)->update(['name'=>$request->newName]);

        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }

    public function newOrder(Request $request)
    {
        $gal = Galery::where('name', $request->name)->first();
        $catg = $gal->category;

        $movingGals = Galery::where('order', '>=', $request->newOrder)
        ->where('category_id',$catg->id)
        ->get();

        $gal->update(['order'=>$request->newOrder]);

        foreach($movingGals as $mGal){
            if($mGal->id !== $gal->id){
                $mGal->update(['order'=>$mGal->order+100]);
            }
        }

        SortOrderProvider::sortGaleries();

        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }

    public function delete(Request $request)
    {
        $galery =  Galery::where('name', $request->name)->first();
        foreach($galery->photos as $photo){
            Storage::disk('public')->delete('images/'.$photo->src);
        }
        $galery->delete();
        SortOrderProvider::sortGaleries();

        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }
}
