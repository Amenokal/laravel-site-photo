<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Galery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\SortOrderProvider;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{

    public function upload(Request $request)
    {
        if($request->hasFile('photos')){
            foreach($request->photos as $photo){

                Storage::disk('public')->put('images', $photo);

                $path = $photo->hashName();
                $id = $request->galeryId;
                $order = Galery::find($id)->photos()->count()+1;

                Photo::create([
                    'src' => $path,
                    'galery_id' => $id,
                    'order' => $order,
                    'highlighted' => false
                    ]);
            }

            SortOrderProvider::sortPhotos();
            return redirect()->route('admin');
        }

    }

    public function highlight(Request $request)
    {
        $photo = Photo::find($request->id);
        $photo->update(['highlighted'=>!$photo->highlighted]);
    }

    public function newOrder(Request $request)
    {
        $photo = Photo::find($request->id);
        $galery = $photo->galery;

        $movingPhotos = Photo::where('order', '>=', $request->newOrder)
        ->where('galery_id',$galery->id)
        ->get();

        $photo->update(['order'=>$request->newOrder]);

        foreach($movingPhotos as $mPhoto){
            if($mPhoto->id !== $photo->id){
                $mPhoto->update(['order'=>$mPhoto->order+100]);
            }
        }

        SortOrderProvider::sortPhotos();

        return view('components.admin-galery',[
            'galery' => $galery
        ]);
    }

    public function delete(Request $request)
    {
        $photo = Photo::find($request->id);
        $galery = $photo->galery;
        Storage::disk('public')->delete('images/'.$photo->src);
        $photo->delete();

        SortOrderProvider::sortPhotos();

        return view('components.admin-galery', [
            'galery' => $galery
        ]);
    }

}
