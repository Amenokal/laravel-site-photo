<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Providers\SortOrderProvider;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        if(!in_array($request->name,  Category::pluck('name')->all()) && $request->name){
            Category::create([
                'name' => $request->name,
                'order' => Category::all()->count()+1
            ]);
        }
        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }

    public function edit(Request $request)
    {
        Category::where('name', $request->oldName)->update(['name'=>$request->newName]);

        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }

    public function newOrder(Request $request)
    {
        $catg = Category::where('name', $request->name)->first();
        $movingCatgs = Category::where('order', '>=', $request->newOrder)->get();

        $catg->update(['order'=>$request->newOrder]);

        foreach($movingCatgs as $mCatg){
            if($mCatg->id !== $catg->id){
                $mCatg->update(['order'=>$mCatg->order+100]);
            }
        }

        SortOrderProvider::sortCategories();

        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }

    public function delete(Request $request)
    {
        $catg = Category::where('name', $request->name)->first();
        foreach($catg->galeries as $gal){
            foreach($gal->photos as $photo){
                Storage::disk('public')->delete('images/'.$photo->src);
            }
        }
        $catg->delete();

        SortOrderProvider::sortCategories();

        return view('components.admin-navbar',[
            'categories' => Category::orderBy('order')->get(),
            'lastcategoryorder' => Category::all()->count()+1
        ]);
    }

}
